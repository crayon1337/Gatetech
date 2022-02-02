<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Repository\Post\PostRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * PostController constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @return LengthAwarePaginator|null
     * @throws Exception
     * @throws Exception
     */
    public function index(): ?LengthAwarePaginator
    {
        return $this->postRepository->all(20, 'Isavailable');
    }

    /**
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function create(PostRequest $request): JsonResponse
    {
        // Validate the request
        $data = $request->validated();

        // Assign a slug if it's not included in the request
        if(!isset($data['slug'])) {
            // If it already exists the title have to be changed. Or include the slug with different one in the request.
            if($this->postRepository->isSlugExists($data['title']))
                return response()->json(['message' => 'The slug already exists in the database'], 422);

            $data['slug'] = Str::slug($data['title']);
        }

        // Create the post
        $post = $this->postRepository->create($data);

        // Return successful response
        return response()->json([
            'message' => 'A new post has been added successfully...',
            'post' => $post,
        ]);
    }

    /**
     * @param $slug
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        return response()->json($this->postRepository->findBySlug($slug));
    }

    /**
     * @param PostRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(PostRequest $request, $slug): JsonResponse
    {
        // Get post by it's slug
        $post = $this->postRepository->findBySlug($slug);

        // Validate the request
        $data = $request->validated();

        // Update the existing post
        $post->update($data);

        // Return successful message
        return response()->json([
            'message' => 'The post has been updated successfully.',
            'post' => $post,
        ]);
    }

    /**
     * @param $slug
     * @return JsonResponse
     */
    public function delete($slug): JsonResponse
    {
        // Get the post by it's slug
        $post = $this->postRepository->findBySlug($slug);

        // Delete the post
        $post->delete();

        // Return successful message
        return response()->json([
            'message' => 'The post has been deleted successfully...',
            'post' => $post
        ]);
    }
}
