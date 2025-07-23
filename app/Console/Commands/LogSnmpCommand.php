<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Printer;
use App\Models\PrinterError;
use App\Notifications\TonerLowNotification;

class LogSnmpCommand extends Command
{
    protected $signature = 'printers:snmp-log';
    protected $description = 'Log SNMP data (toner levels, errors, page count).';

    public function handle()
    {
        $printers = Printer::all();
        foreach ($printers as $printer) {
            $ip = $printer->ip_address;
            $tonerLevelOid = '1.3.6.1.2.1.43.11.1.1.9.1.1'; // adjust per type
            $levelRaw = @snmpget($ip, 'public', $tonerLevelOid);
            $level = $levelRaw ? (int)filter_var($levelRaw, '/\d+/') : null;
            
            if ($level !== null) {
                if ($level < 20) {
                    $printer->notify(new TonerLowNotification($printer, $printer->toners()->latest()->first(), $level));
                    $this->info("Notified low toner for {$printer->name}");
                }
            }

            // Check for errors
            $errorOid = '1.3.6.1.2.1.43.18.1.1.8.1.1';
            $errRaw = @snmpget($ip, 'public', $errorOid);
            if ($errRaw !== false) {
                $msg = trim(str_replace(['STRING: ', '"'], '', $errRaw));
                PrinterError::create(['printer_id' => $printer->id, 'error_message' => $msg]);
                $this->info("Error logged: $msg");
            }
        }
    }
}
