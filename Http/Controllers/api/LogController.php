<?php

namespace App\Http\Controllers\api\v1\logs;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Support\Carbon;

class LogController extends Controller
{
    /**
     * List of all log items.
     *
     * @return \App\Models\Log
     */
    public function index(Request $request)
    {
        //check optional params
        //items per page
        $count = $request->perpage ?? 10;
        $count = $count < 100 ? $count : 100;

        //filters
        $filterBy = $request->filterBy;

        //sorting
        $sortByString = "";
        $i = 0;
        if ($request->sortBy) {
            $sortBy = $request->sortBy;
            $sortDesc = $request->sortDesc;
            foreach ($sortBy as $sb) {
                //check if actual column of table (protect against sql injection since we are using orderByRaw)
                if (Log::isValidColumn($sb)) {
                    $sortByString .= $sb . ($sortDesc[$i] == "true" ? ' DESC' : ' ASC') . ", ";
                    $i++;
                }
            }
            $sortByString = substr($sortByString, 0, -2);
        }

        //date range
        $start = Carbon::createFromFormat('Y-m-d H:i:s', $request->startDate . " 00:00:00");
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $request->endDate . " 23:59:59");
        if ($start > $end) {
            $tmp = $start;
            $start = $end;
            $end = $tmp;
        }

        //search query
        if ($search = $request->q) {
            //with search query
            if ($sortByString != "") {
                if ($filterBy) {
                    if ($start && $end) {
                        $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                            ->where(function ($query) use ($search, $filterBy) {
                                foreach ($filterBy as $fb) {
                                    $query->orWhere($fb, 'LIKE',  '%' . $search . '%');
                                }
                            })
                            ->whereBetween('created_at', [$start, $end])
                            ->orderByRaw($sortByString)
                            ->paginate($count);
                    } else {
                        $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                            ->where(function ($query) use ($search, $filterBy) {
                                foreach ($filterBy as $fb) {
                                    $query->orWhere($fb, 'LIKE',  '%' . $search . '%');
                                }
                            })
                            ->orderByRaw($sortByString)
                            ->paginate($count);
                    }
                } else {
                    if ($start && $end) {
                        $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                            ->where(function ($query) use ($search) {
                                $query->orWhere('description', 'LIKE', '%' . $search . '%');
                                $query->orWhere('type', 'LIKE', '%' . $search . '%');
                                $query->orWhere('result', 'LIKE', '%' . $search . '%');
                                $query->orWhere('level', 'LIKE', '%' . $search . '%');
                                $query->orWhere('ip', 'LIKE', '%' . $search . '%');
                                $query->orWhere('user', 'LIKE', '%' . $search . '%');
                            })
                            ->whereBetween('created_at', [$start, $end])
                            ->orderByRaw($sortByString)
                            ->paginate($count);
                    } else {
                        $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                            ->where(function ($query) use ($search) {
                                $query->orWhere('description', 'LIKE', '%' . $search . '%');
                                $query->orWhere('type', 'LIKE', '%' . $search . '%');
                                $query->orWhere('result', 'LIKE', '%' . $search . '%');
                                $query->orWhere('level', 'LIKE', '%' . $search . '%');
                                $query->orWhere('ip', 'LIKE', '%' . $search . '%');
                                $query->orWhere('user', 'LIKE', '%' . $search . '%');
                            })
                            ->orderByRaw($sortByString)
                            ->paginate($count);
                    }
                }
            } else {
                if ($filterBy) {
                    if ($start && $end) {
                        $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                            ->where(function ($query) use ($search, $filterBy) {
                                foreach ($filterBy as $fb) {
                                    $query->orWhere($fb, 'LIKE',  '%' . $search . '%');
                                }
                            })
                            ->whereBetween('created_at', [$start, $end])
                            ->paginate($count);
                    } else {
                        $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                            ->where(function ($query) use ($search, $filterBy) {
                                foreach ($filterBy as $fb) {
                                    $query->orWhere($fb, 'LIKE',  '%' . $search . '%');
                                }
                            })
                            ->paginate($count);
                    }
                } else {
                    if ($start && $end) {
                        $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                            ->where(function ($query) use ($search) {
                                $query->orWhere('description', 'LIKE', '%' . $search . '%');
                                $query->orWhere('type', 'LIKE', '%' . $search . '%');
                                $query->orWhere('result', 'LIKE', '%' . $search . '%');
                                $query->orWhere('level', 'LIKE', '%' . $search . '%');
                                $query->orWhere('ip', 'LIKE', '%' . $search . '%');
                                $query->orWhere('user', 'LIKE', '%' . $search . '%');
                            })
                            ->whereBetween('created_at', [$start, $end])
                            ->paginate($count);
                    } else {
                        $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                            ->where(function ($query) use ($search) {
                                $query->orWhere('description', 'LIKE', '%' . $search . '%');
                                $query->orWhere('type', 'LIKE', '%' . $search . '%');
                                $query->orWhere('result', 'LIKE', '%' . $search . '%');
                                $query->orWhere('level', 'LIKE', '%' . $search . '%');
                                $query->orWhere('ip', 'LIKE', '%' . $search . '%');
                                $query->orWhere('user', 'LIKE', '%' . $search . '%');
                            })
                            ->paginate($count);
                    }
                }
            }
        } else {
            //without search query
            if ($sortByString != "") {
                if ($start && $end) {
                    $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                        ->whereBetween('created_at', [$start, $end])
                        ->orderByRaw($sortByString)
                        ->paginate($count);
                } else {
                    $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                        ->orderByRaw($sortByString)
                        ->paginate($count);
                }
            } else {
                if ($start && $end) {
                    $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                        ->whereBetween('created_at', [$start, $end])
                        ->paginate($count);
                } else {
                    $users = Log::select('id', 'description', 'type', 'result', 'level', 'ip', 'user', 'created_at')
                        ->paginate($count);
                }
            }
        }

        return ($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$id) {
            Log::debug('Log ID expected. Operation aborted.');
            return;
        }

        //include user info for specified resource
        return Log::find($id);
    }
}
