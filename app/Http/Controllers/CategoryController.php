<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repository\Category\CategoryRepository;
use Exception;
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
     */
    public function create(CategoryRequest $request): JsonResponse
    {
        // Validate the data
        $data = $request->validated();

        // Assign auto slug if the request does not include a slug.
        // Also make sure the slug does not exist in the database.
        if(!isset($data['slug'])) {

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
        return response()->json($this->categoryRepository->findBySlug($slug));
    }

    /**
     * @param CategoryRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, $slug): JsonResponse
    {
        $category = $this->categoryRepository->findBySlug($slug);

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
     */
    public function delete($slug): JsonResponse
    {
        // Get the category by it's slug
        $category = $this->categoryRepository->findBySlug($slug);

        // Delete the category
        $category->delete();

        // Return successfull message
        return response()->json([
            'message' => 'Category has been deleted successfully...',
        ]);
    }
}
