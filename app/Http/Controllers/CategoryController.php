<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repository\Category\CategoryRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return LengthAwarePaginator|null
     * @throws Exception
     */
    public function index(): ?LengthAwarePaginator
    {
        return $this->categoryRepository->all(20, 'Isavailable');
    }

    /**
     * @param CategoryRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function create(CategoryRequest $request): JsonResponse
    {
        // Authorize the request.
        $this->authorize('manage', Category::class);

        // Validate the data
        $data = $request->validated();

        // Assign auto slug if the request does not include a slug.
        // Also make sure the slug does not exist in the database.
        if(!isset($data['slug'])) {

            // If it already exists the name have to be changed. Or include the slug with different one in the request.
            if($this->categoryRepository->isSlugExists($data['name']))
                return response()->json(['message' => 'The slug already exists in the database'], 422);

            $data['slug'] = Str::slug($data['name']);
        }

        // Create the category
        $category = $this->categoryRepository->create($data);

        // Return successful message and the category
        return response()->json([
            'message'  => 'A new category has been added...',
            'category' => $category,
        ]);
    }

    /**
     * @param $slug
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        return response()->json(['category' => $this->categoryRepository->findBySlug($slug), 'posts' => $this->categoryRepository->getPosts($slug)]);
    }

    /**
     * @param CategoryRequest $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(CategoryRequest $request, $id): JsonResponse
    {
        // Authorize the request
        $this->authorize('manage', Category::class);

        // Get the category by it's ID
        $category = $this->categoryRepository->findOrFail($id);

        // Validate the data
        $data = $request->validated();

        // Update the category
        $category->update($data);

        // Return successful message and the category
        return response()->json([
            'message'  => 'Category has been updated',
            'category' => $category,
        ]);
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function delete($slug): JsonResponse
    {
        // Authorize the request
        $this->authorize('manage', Category::class);

        // Get the category by it's slug
        $category = $this->categoryRepository->findBySlug($slug);

        // Delete the category
        $category->delete();

        // Return successful message
        return response()->json([
            'message' => 'Category has been deleted successfully...',
        ]);
    }
}
