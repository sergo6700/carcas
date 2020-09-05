<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class MoveV2Data
 * @package App\Console\Commands
 */
class MoveV2Data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:v2:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move data from v2 to v3';

    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $v2Connection;

    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $v3Connection;

    /**
     *
     */
    const BATCH_INSERT = 1000;

    /**
     * MoveV2Data constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->v3Connection = DB::connection('mysql');
        $this->v2Connection = DB::connection('mysql_v2');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->v3Connection->beginTransaction();

        try {
            $this->moveTable('roles');
            $this->moveTable('permissions');
            $this->moveTable('model_has_permissions');
            $this->moveTable('model_has_roles');
            $this->moveTable('role_has_permissions');
            $this->moveTable('oauth_access_tokens');
            $this->moveTable('oauth_auth_codes');
            $this->moveTable('oauth_clients');
            $this->moveTable('oauth_personal_access_clients');
            $this->moveTable('oauth_refresh_tokens');

            $this->moveUsers();
            $this->moveVatTypes();
            $this->moveCompanies();
            $this->moveClients();
            $this->moveProperties();
            $this->moveUnitCategories();
            $this->moveRoomTypes();
            $this->moveDerivationRules();
            $this->moveUnits();
            $this->moveRates();
            $this->moveReservations();
            $this->moveUsersProperties();

            $this->v3Connection->commit();
        } catch (\Exception $exception) {
            $this->v3Connection->rollBack();
            $this->info(substr($exception->getMessage(), 0, 250));
        }
    }

    /**
     * @param $table
     */
    public function moveTable($table)
    {
        $this->info("Start moving $table");

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table($table)->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table($table)
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $count++;
            $v3Data[] = $v2item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table($table)
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count $table are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info("Table $table moved" . PHP_EOL);
    }

    /**
     *
     */
    public function moveClients()
    {
        $this->info('Start moving clients');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('clients')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('clients')
            ->whereNotNull('company_id')
            ->where('company_id', '<>', 0)
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'company_id',
                'type',
                'name',
                'first_name',
                'last_name',
                'email',
                'country',
                'state',
                'city',
                'address',
                'phone',
                'post_code',
                'vat_code',
                'tax_code',
                'sdi',
                'locale',
                'notes',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $v3Item['email'] = $v3Item['email'] || 'donotreply@ciaobooking.com';
            $v3Item['sdi'] = $v2item['SDI'];
            $v3Item['vat_code'] = $v2item['vatcode'];
            $v3Item['tax_code'] = $v2item['taxcode'];
            $v3Item['post_code'] = $v2item['postcode'];
            $v3Item['locale'] = $v2item['language'];

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('clients')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count clients are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table clients moved' . PHP_EOL);
    }

    /**
     *
     */
    public function moveCompanies()
    {
        $this->info('Start moving companies');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('companies')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('companies')
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'vat_type_id',
                'name',
                'email',
                'customer_name',
                'country',
                'state',
                'city',
                'address',
                'phone',
                'post_code',
                'vat_code',
                'tax_code',
                'bill_id',
                'invoice_id',
                'invoice_series',
                'receipt_id',
                'receipt_series',
                'entratel_username',
                'entratel_password',
                'entratel_pin',
                'entratel_account_type',
                'entratel_account_subtype',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $v3Item['email'] = $v3Item['email'] ? $v3Item['email'] : 'donotreply@ciaobooking.com';
            $v3Item['vat_code'] = $v2item['vatcode'];
            $v3Item['tax_code'] = $v2item['taxcode'];
            $v3Item['post_code'] = $v2item['postcode'];
            $v3Item['vat_type_id'] = $v2item['vat_type'];
            $v3Item['name'] = $v2item['company_name'];
            $v3Item['phone'] = $v2item['mobile'];

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('companies')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count companies are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table companies moved' . PHP_EOL);
    }

    /**
     *
     */
    public function moveDerivationRules()
    {
        $this->info('Start moving derivation_rules');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('derivation_rules')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('derivation_rules')
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'room_type_id',
                'parent_id',
                'amount',
                'amount_status',
                'availability',
                'restrictions',
                'stop_sell',
                'length_of_stay',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $v3Item['amount'] = $v2item['price'];
            $v3Item['amount_status'] = $v2item['price_status'];
            $v3Item['length_of_stay'] = $v2item['restrictions'];

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('derivation_rules')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count derivation_rules are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table derivation_rules moved' . PHP_EOL);
    }

    /**
     *
     */
    public function moveProperties()
    {
        $this->info('Start moving properties');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('properties')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('properties')
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'company_id',
                'vat_type_id',
                'name',
                'email',
                'email_alternative',
                'country',
                'city',
                'street',
                'phone',
                'currency',
                'secom_sms_sent',
                'secom_email_sent',
                'secom_tmp_api_key',
                'secom_api_user',
                'emerchant_username',
                'emerchant_password',
                'city_tax_type',
                'city_tax_amount',
                'city_tax_max_days',
                'city_tax_age_exclusion',
                'check_min_stay_checkin_date',
                'accept_min_stay_multiple',
                'show_unavailable',
                'enable_stopsell',
                'check_out',
                'check_in_to',
                'check_in_from',
                'police_type',
                'police_user',
                'police_password',
                'police_cert_password',
                'stat_username',
                'stat_password',
                'stat_type',
                'stat_structure_code',
                'stat_external_location_id',
                'octorate_property_id',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $v3Item['email'] = $v3Item['email'] || 'donotreply@ciaobooking.com';
            $v3Item['octorate_property_id'] = $v2item['octorate_id_property'];
            $v3Item['stat_username'] = $v2item['istat_username'];
            $v3Item['stat_password'] = $v2item['istat_password'];
            $v3Item['stat_type'] = $v2item['istat_type'];
            $v3Item['stat_structure_code'] = $v2item['istat_structure_code'];

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('properties')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count properties are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table properties moved' . PHP_EOL);
    }

    /**
     *
     */
    public function moveRates()
    {
        $this->info('Start moving rates');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('rates')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('rooms_rate_calendar')
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'room_type_id',
                'date',
                'amount',
                'availability',
                'min_stay',
                'max_stay',
                'cta',
                'ctd',
                'stop_sell',
                'cut_off',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $v3Item['amount'] = $v2item['price'];
            $v3Item['availability'] = $v2item['units'];

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('rates')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count rates are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table rates moved' . PHP_EOL);
    }

    /**
     *
     */
    public function moveUnitCategories()
    {
        $this->info('Start moving unit_categories');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('unit_categories')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('rate_category')
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'property_id',
                'name',
                'color',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('unit_categories')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count unit_categories are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table unit_categories moved' . PHP_EOL);
    }

    /**
     *
     */
    public function moveUsers()
    {
        $this->info('Start moving users');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('users')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('users')
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'name',
                'email',
                'password',
                'locale',
                'remember_token',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('users')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count users are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table users moved' . PHP_EOL);
    }

    /**
     *
     */
    public function moveVatTypes()
    {
        $this->info('Start moving vat_types');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('vat_types')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('vat_type')
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'name',
                'value',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('vat_types')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count vat_types are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table vat_types moved' . PHP_EOL);
    }

    /**
     *
     */
    public function moveRoomTypes()
    {
        $this->info('Start moving room_types');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('room_types')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('room_type')
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'property_id',
                'unit_category_id',
                'name',
                'quantity',
                'adults',
                'children',
                'bathrooms',
                'min_price',
                'cfnd',
                'infants',
                'breakfast',
                'refundable',
                'min_stay',
                'max_stay',
                'octorate_room_type_id',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $v3Item['unit_category_id'] = $v2item['rate_category_id'];
            $v3Item['octorate_room_type_id'] = $v2item['channel_manager_id'];

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('room_types')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count room_types are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table room_types moved' . PHP_EOL);
    }

    /**
     *
     */
    public function moveUnits()
    {
        $this->info('Start moving units');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('units')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('units')
            ->get();

        $v2UnitRoomTypes = $this->v2Connection
            ->table('units_room_type')
            ->join('room_type', 'room_type.id', '=', 'units_room_type.room_type_id')
            ->pluck('rate_category_id', 'unit_id')
            ->toArray();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'property_id',
                'unit_category_id',
                'name',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $v3Item['unit_category_id'] = Arr::get($v2UnitRoomTypes, $v2item['id']);

            if (empty($v3Item['unit_category_id'])) {
                $count++;
                continue;
            }

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('units')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count units are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table units moved' . PHP_EOL);
    }

    /**
     *
     */
//    public function moveReservations()
//    {
//        $unitIds = $this->v3Connection
//            ->table('units')
//            ->pluck('id')
//            ->toArray();
//
//        $clientIds = $this->v3Connection
//            ->table('clients')
//            ->pluck('id')
//            ->toArray();
//
//        $this->info('Start moving reservations');
//
//        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
//        $this->v3Connection->table('reservations')->truncate();
//        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');
//
//        $v2Data = $this->v2Connection
//            ->table('reservations')
//            ->select([
//                'reservations.*',
//                'reservations_main.res_id',
//            ])
//            ->join('clients', 'clients.id', '=', 'reservations.client_id')
//            ->join('properties', 'properties.id', '=', 'reservations.property_id')
//            ->leftJoin('reservations_main', 'reservations_main.id', '=', 'reservations.res_main_id')
//            ->whereIn('reservations.client_id', $clientIds)
//            ->get();
//
//        $total = $v2Data->count();
//
//        $count = 0;
//        $v3Data = [];
//
//        foreach ($v2Data->toArray() as $v2item) {
//            $v2item = (array) $v2item;
//
//            $fields = [
//                'id',
//                'user_id',
//                'property_id',
//                'room_type_id',
//                'client_id',
//                'unit_id',
//                'octorate_reservation_id',
//                'res_id',
//                'status',
//                'start_date',
//                'end_date',
//                'amount',
//                'city_tax',
//                'ota_fee',
//                'currency',
//                'source',
//                'arrival_time',
//                'adults',
//                'children',
//                'infants',
//                'is_ciaobooking',
//                'is_paid',
//                'is_refundable',
//                'ccs_token',
//                'ccs_prepaid',
//                'ccs_brand',
//                'ccs_bank',
//                'ccs_scheme',
//                'ccs_type',
//                'ccs_expire_date',
//                'ccs_pan',
//                'ccs_card_holder',
//                'ota_note',
//                'internal_note',
//                'service_note',
//                'created_at',
//                'updated_at',
//            ];
//
//            $v3Item = [];
//
//            foreach ($fields as $field) {
//                $v3Item[$field] = Arr::get($v2item, $field);
//            }
//
//            $v3Item['amount'] = $v2item['total'];
//            $v3Item['source'] = $v2item['site_name'];
//            $v3Item['user_id'] = $v2item['author_id'];
//            $v3Item['service_note'] = $v2item['service_notes'];
//            $v3Item['is_refundable'] = $v2item['room_refundable'];
//            $v3Item['arrival_time'] = $v2item['arrival_time'] ? carbon($v2item['arrival_time'])->format('H:i') : null;
//
//            if ($v2item['status'] === 'completed') {
//                $v3Item['status'] = \ConstReservationStatuses::COMPLETED;
//            }
//            if ($v2item['status'] === 'canceled') {
//                $v3Item['status'] = \ConstReservationStatuses::CANCELED;
//            }
//            if ($v2item['status'] === 'pending') {
//                $v3Item['status'] = \ConstReservationStatuses::PENDING;
//            }
//            if ($v2item['status'] === 'update') {
//                $v3Item['status'] = \ConstReservationStatuses::UPDATE;
//            }
//
//            if (!empty($v3Item['unit_id']) && !in_array($v3Item['unit_id'], $unitIds)) {
//                $count++;
//                continue;
//            }
//
//            $count++;
//            $v3Data[] = $v3Item;
//
//            if ($count === self::BATCH_INSERT || $count === $total) {
//                $this->v3Connection
//                    ->table('reservations')
//                    ->insert($v3Data);
//
//                $total = $total - $count;
//                $this->info("$count reservations are moved, left $total");
//
//                $count = 0;
//                $v3Data = [];
//            }
//        }
//
//        $this->info('Table reservations moved' . PHP_EOL);
//    }

    /**
     *
     */
    public function moveUsersProperties()
    {
        $this->info('Start moving users_properties');

        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->v3Connection->table('users_properties')->truncate();
        $this->v3Connection->statement('SET FOREIGN_KEY_CHECKS = 1');

        $v2Data = $this->v2Connection
            ->table('users_properties')
            ->select([
                'users_properties.*'
            ])
            ->join('users', 'users.id', '=', 'users_properties.user_id')
            ->join('properties', 'properties.id', '=', 'users_properties.property_id')
            ->get();

        $total = $v2Data->count();

        $count = 0;
        $v3Data = [];

        foreach ($v2Data->toArray() as $v2item) {
            $v2item = (array) $v2item;

            $fields = [
                'id',
                'user_id',
                'property_id',
                'created_at',
                'updated_at',
            ];

            $v3Item = [];

            foreach ($fields as $field) {
                $v3Item[$field] = Arr::get($v2item, $field);
            }

            $count++;
            $v3Data[] = $v3Item;

            if ($count === self::BATCH_INSERT || $count === $total) {
                $this->v3Connection
                    ->table('users_properties')
                    ->insert($v3Data);

                $total = $total - $count;
                $this->info("$count users_properties are moved, left $total");

                $count = 0;
                $v3Data = [];
            }
        }

        $this->info('Table users_properties moved' . PHP_EOL);
    }
}
