<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTaskAPIRequest;
use App\Http\Requests\API\UpdateTaskAPIRequest;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Auth;
/**
 * Class TaskAPIController
 */
class TaskAPIController extends AppBaseController
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepository = $taskRepo;
    }

    /**
     * Display a listing of the Tasks.
     * GET|HEAD /tasks
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = $this->taskRepository
        ->when($request->has('title'),function($q) use($request){
           return $q->where('title','like','%'.$request->get('title','').'%');
        })
        ->when($request->has('status'),function($q) use($request){
            return $q->where('status',$request->get('status',''));
        })
        ->when($request->has('start_date'), function ($q) use($request){
            $q->whereDate('due_date','>=',$request->get('start_date'));
        })
        ->when($request->has('end_date'), function ($q) use($request){
            $q->whereDate('due_date','<=',$request->get('end_date'));
        })
        ->where('user_id',Auth::id())
        
        ->paginate($request->get('limit',100));

        return $this->sendResponse($tasks->toArray(), 'Tasks retrieved successfully');
    }

    /**
     * Store a newly created Task in storage.
     * POST /tasks
     */
    public function store(CreateTaskAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        
        $input['user_id']=Auth::id();
        
        $task = $this->taskRepository->create($input);

        return $this->sendResponse($task->toArray(), 'Task saved successfully');
    }

    /**
     * Display the specified Task.
     * GET|HEAD /tasks/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Task $task */
        $task = $this->taskRepository->where('user_id',Auth::id())->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        return $this->sendResponse($task->toArray(), 'Task retrieved successfully');
    }

    /**
     * Update the specified Task in storage.
     * PUT/PATCH /tasks/{id}
     */
    public function update($id, UpdateTaskAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        
        $input['user_id']=Auth::id();
        /** @var Task $task */
        $task = $this->taskRepository->where('user_id',Auth::id())->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $task = $this->taskRepository->update($input, $id);

        return $this->sendResponse($task->toArray(), 'Task updated successfully');
    }

    /**
     * Remove the specified Task from storage.
     * DELETE /tasks/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $task->delete();

        return $this->sendSuccess('Task deleted successfully');
    }
}
