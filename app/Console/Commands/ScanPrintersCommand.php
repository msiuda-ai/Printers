<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Printer;
use App\Models\PrinterHistory;
use App\Models\PrinterError;
use App\Models\Toner;
use Illuminate\Support\Facades\Log;

class ScanPrintersCommand extends Command
{
    protected $signature = 'snmp:scan-printers';

    protected $description = 'Scan network for printers via SNMP, update DB and history';

    public function handle()
    {
        // Pro jednoduchost předpokládáme rozsah IP 192.168.1.0/24 (přizpůsobit dle potřeby)
        $network = '192.168.1.';
        $timeout = 1000000; // mikrosekundy, 1 sekunda

        for ($i = 1; $i <= 254; $i++) {
            $ip = $network . $i;

            // Předpoklad: zkusit získat sysName OID z tiskárny
            $sysNameOid = '1.3.6.1.2.1.1.5.0'; // sysName.0
            $sysDescrOid = '1.3.6.1.2.1.1.1.0'; // sysDescr.0

            $sysName = @snmpget($ip, 'public', $sysNameOid, $timeout);
            $sysDescr = @snmpget($ip, 'public', $sysDescrOid, $timeout);

            if ($sysName !== false && $sysDescr !== false) {
                $sysName = trim(str_replace(['STRING: ', '"'], '', $sysName));
                $sysDescr = trim(str_replace(['STRING: ', '"'], '', $sysDescr));

                $printer = Printer::where('ip_address', $ip)->first();

                if (!$printer) {
                    // Nová tiskárna
                    $printer = Printer::create([
                        'ip_address' => $ip,
                        'name' => $sysName,
                        'location' => null,
                        'printer_type_id' => 1, // default typ, upravit dle potřeby
                        'serial_number' => null,
                    ]);

                    $this->info("Nová tiskárna přidána: $ip / $sysName");
                } else {
                    // Pokud se změnila IP nebo jméno, zaznamenáme změnu
                    if ($printer->name !== $sysName) {
                        PrinterHistory::create([
                            'printer_id' => $printer->id,
                            'field_changed' => 'name',
                            'old_value' => $printer->name,
                            'new_value' => $sysName,
                            'changed_by' => 'system',
                        ]);
                        $printer->name = $sysName;
                        $printer->save();
                        $this->info("Jméno tiskárny aktualizováno: $ip / $sysName");
                    }
                }
                // TODO: Přidat rozpoznání typu tiskárny a tonerů podle OID
            }
        }

        $this->info('SNMP scan dokončen.');
    }
}
