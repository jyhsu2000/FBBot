<?php

namespace App\DataTables;

use App\Qualification;
use Illuminate\Database\Eloquent\Builder;
use Yajra\Datatables\Services\DataTable;

class QualificationsDataTable extends DataTable
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
            ->addColumn('action', 'qualification.datatables.action')
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
        /* @var Builder $query */
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
            ->addAction(['title' => '操作'])
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
            'id'         => ['title' => '#'],
            'player_id'  => ['title' => '玩家'],
            'created_at' => ['title' => '取得時間'],
            'get_at'     => ['title' => '抽獎時間'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'qualifications_' . time();
    }
}
