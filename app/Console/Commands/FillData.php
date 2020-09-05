<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class FillData
 * @package App\Console\Commands
 */
class FillData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill v3 data';

    /**
     * MoveV2Data constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            $this->fillRoomTypes();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     *
     */
    public function fillRoomTypes()
    {
        $collection = DB::table('derivation_rules')
            ->select([
                'derivation_rules.parent_id',
                'derivation_rules.room_type_id',
                'room_types.id',
                'room_types.property_id',
            ])
            ->join('room_types', function ($join) {
                $join->on('room_types.id', '=', 'derivation_rules.room_type_id')
                    ->orOn('room_types.id', '=', 'derivation_rules.parent_id');
            })
            ->get();

        $parents = $collection->pluck('parent_id')->toArray();
        $parents = array_unique($parents);

        $children = [];

        foreach ($collection as $item) {
            $item = (array) $item;

            $isDifferent = !!$collection
                ->where('parent_id', $item['parent_id'])
                ->where('room_type_id', $item['room_type_id'])
                ->where('property_id', '<>', $item['property_id'])
                ->count();

            if (!$isDifferent) {
                $children[] = $item['room_type_id'];
            }
        }

        $children = array_unique($children);

        DB::table('room_types')->whereIn('id', $parents)->update(['is_parent' => \ConstGeneralStatuses::YES]);
        DB::table('room_types')->whereIn('id', $children)->update(['is_child' => \ConstGeneralStatuses::YES]);
    }
}
