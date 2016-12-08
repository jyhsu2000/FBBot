<?php

namespace App\DataTables;

use App\Player;
use Yajra\Datatables\Services\DataTable;

class PlayersDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Player::query();

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->ajax('')
            ->parameters($this->getBuilderParameters())
            ->parameters([
                'order'      => [[0, 'asc']],
                'pageLength' => 50,
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'data'  => 'id',
                'name'  => 'id',
                'title' => '#',
            ],
            [
                'data'  => 'nid',
                'name'  => 'nid',
                'title' => 'NID',
            ],

            [
                'data'  => 'app_uid',
                'name'  => 'app_uid',
                'title' => 'App UID',
            ],

            [
                'data'  => 'uid',
                'name'  => 'uid',
                'title' => 'UID',
            ],

            [
                'data'  => 'in_question',
                'name'  => 'in_question',
                'title' => 'In Question',
            ],

            [
                'data'  => 'time',
                'name'  => 'time',
                'title' => 'Times',
            ],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'players_' . time();
    }
}
