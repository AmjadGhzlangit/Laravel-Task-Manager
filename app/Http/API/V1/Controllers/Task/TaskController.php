<?php

namespace App\Http\API\V1\Controllers\Task;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Task\TaskRepository;
use App\Http\API\V1\Requests\Task\StoreTaskRequest;
use App\Http\API\V1\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Traits\FileUpload;
use Illuminate\Http\JsonResponse;

/**
 * @group User
 * APIs for User Management
 *
 * @subgroup Task
 *
 * @subgroupDescription APIs for Task  Management
 */
class TaskController extends Controller
{
    use FileUpload;

    public function __construct(protected TaskRepository $taskRepository)
    {
        $this->middleware(['auth:sanctum']);
    }

    /**
     * Show all tasks
     *
     * This endpoint lets you show all tasks
     *
     * @responseFile storage/responses/tasks/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[title] string Field to filter items by title.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam sort string Field to sort items by title,status,created_at,updated_at.
     * @queryParam filter[search] string Field to perform a custom search.
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->taskRepository->index();

        return $this->showAll($paginatedData->getData(), TaskResource::class, $paginatedData->getPagination());
    }

    /**
     * Show Specific Task
     *
     * This endpoint lets you show specific task
     *
     * @responseFile storage/responses/tasks/show.json
     */
    public function show(Task $task): JsonResponse
    {
        return $this->showOne($this->taskRepository->show($task), TaskResource::class);
    }

    /**
     * Add Task
     *
     * This endpoint lets you add a new task
     *
     * @responseFile storage/responses/tasks/store.json
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $taskData = $request->validated();
        unset($taskData['images']);
        $task = $this->taskRepository->store($taskData);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->uploadFile($task, $image, 'images');
            }
        }

        return $this->showOne($task, TaskResource::class, __('The Task added successfully'));
    }

    /**
     * Update specific task
     *
     * This endpoint lets you update a specific task
     *
     * @responseFile storage/responses/tasks/update.json
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $taskData = $request->validated();
        unset($taskData['images']);

        $updatedTask = $this->taskRepository->update($task, $taskData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->uploadFile($updatedTask, $image, 'images');
            }
        }

        return $this->showOne($updatedTask, TaskResource::class, __('The Task updated successfully'));
    }

    /**
     * Delete specific task
     *
     * This endpoint lets you delete a specific task
     *
     * @responseFile storage/responses/tasks/delete.json
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->taskRepository->delete($task);

        return $this->responseMessage(__('The Task deleted successfully'));
    }
}
