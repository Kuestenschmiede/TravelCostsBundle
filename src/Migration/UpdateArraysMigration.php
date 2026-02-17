<?php

namespace con4gis\TravelCostsBundle\Migration;

use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\CoreBundle\Migration\MigrationInterface;
use Contao\CoreBundle\Migration\MigrationResult;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

class UpdateArraysMigration implements MigrationInterface
{

    private array $fields = [
        // tl_c4g_travel_costs_settings
        'tariffs',
        'addPriceOptions',
        // tl_c4g_travel_costs_tariffs
        'distancePrice',
    ];

    public function __construct(
        private readonly Connection $connection,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function getName(): string
    {
        return "con4gis_travel_costs_update_arrays_migration";
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (
            !$schemaManager->tablesExist([
                'tl_c4g_travel_costs_settings',
                'tl_c4g_travel_costs_tariffs'
            ])
        ) {
            return false;
        }

        $sql = "SELECT tariffs, addPriceOptions FROM tl_c4g_travel_costs_settings";
        $settings = $this->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();

        $sql = "SELECT distancePrice FROM tl_c4g_travel_costs_tariffs";
        $tariffs = $this->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();

        $datasets = array_merge($settings, $tariffs);

        foreach ($datasets as $dataset) {
            foreach ($this->fields as $field) {
                if (array_key_exists($field, $dataset) && $this->checkForSerializedValue($dataset[$field])) {
                    return true;
                }
            }
        }

        return false;
    }

    public function run(): MigrationResult
    {
        $updateCtr = 0;

        $sql = "SELECT id, tariffs, addPriceOptions FROM tl_c4g_travel_costs_settings";
        $settings = $this->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();

        $sql = "SELECT id, distancePrice FROM tl_c4g_travel_costs_tariffs";
        $dbTariffs = $this->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();

        if ($this->shouldRun()) {
            $this->logger->info("Running migration...");
            foreach ($settings as $setting) {

                // check again if we have to migrate these fields
                if ($this->checkForSerializedValue($setting['tariffs'])) {
                    $tariffs = StringUtil::deserialize($setting['tariffs'], true);
                    $tariffs = implode(",", $tariffs);
                }

                if ($this->checkForSerializedValue($setting['addPriceOptions'])) {
                    $addPriceOptions = StringUtil::deserialize($setting['addPriceOptions'], true);
                    $addPriceOptions = json_encode($addPriceOptions);
                }

                $sql = "UPDATE tl_c4g_travel_costs_settings SET tariffs = ?, addPriceOptions = ? WHERE id=?";
                $this->connection->executeQuery(
                    $sql,
                    [
                        $tariffs ?? $setting['tariffs'],
                        $addPriceOptions ?? $setting['addPriceOptions'],
                        $setting['id']
                    ]
                );
                $updateCtr++;
            }

            foreach ($dbTariffs as $tariff) {

                // check again if we have to migrate these fields
                if ($this->checkForSerializedValue($tariff['distancePrice'])) {
                    $distancePrice = StringUtil::deserialize($tariff['distancePrice'], true);
                    $distancePrice = json_encode($distancePrice);
                }

                $sql = "UPDATE tl_c4g_travel_costs_tariffs SET distancePrice = ? WHERE id=?";
                $this->connection->executeQuery(
                    $sql,
                    [
                        $distancePrice ?? $tariff['distancePrice'],
                        $tariff['id']
                    ]
                );
                $updateCtr++;
            }

            return new MigrationResult(
                true,
                sprintf(
                    "Es wurden %d Datensätze aktualisiert",
                    $updateCtr
                )
            );
        } else {

            return new MigrationResult(
                true,
                "Keine Migration erforderlich."
            );
        }

    }

    private function checkForSerializedValue($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        if (
            str_starts_with($value, "a:")
            || str_starts_with($value, "O:")
            || str_starts_with($value, "i:")
        ) {
            // serialized array, object or int
            return true;
        }

        return false;
    }
}