<?php

namespace App\DataTables;

use App\Qualification;
use Yajra\Datatables\Services\DataTable;

class QualificationDataTable extends DataTable
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
            ->addColumn('action', 'qualification.action')
            ->editColumn('player_id', function (Qualification $qualification) {
                return $qualification->player->nid;
            })
            ->filterColumn('player_id', function ($query, $keyword) {
                $query->whereIn('player_id', function ($query) use ($keyword) {
                    $query->select('players.id')
                        ->from('players')
                        ->join('qualifications', 'players.id', '=', 'qualifications.player_id')
                        ->whereRaw('players.nid LIKE ?', ['%' . $keyword . '%']);
                });
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Qualification::with('player');

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
            ->addAction(['width' => '80px'])
            ->parameters($this->getBuilderParameters())
            ->parameters([
                'order'      => [[0, 'desc']],
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
                'data'  => 'player_id',
                'name'  => 'player_id',
                'title' => '玩家',
            ],
            [
                'data'  => 'created_at',
                'name'  => 'created_at',
                'title' => '取得時間',
            ],
            [
                'data'  => 'get_at',
                'name'  => 'get_at',
                'title' => '抽獎時間',
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
        return 'qualificationdatatables_' . time();
    }
}
