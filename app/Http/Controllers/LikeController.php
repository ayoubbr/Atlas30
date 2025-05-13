<?php

namespace App\Http\Controllers;

use App\Repository\Impl\ILikeRepository;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    private $likeRepository;

    public function __construct(ILikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function toggleLike($groupId, $postId)
    {
        $userId = Auth::id();
        $this->likeRepository->toggleLike($postId, $userId);
        return redirect()->back();
    }

    public function getLikeCount($postId)
    {
        $count = $this->likeRepository->getLikeCount($postId);
        return response()->json(['count' => $count]);
    }

    public function checkUserLiked($postId)
    {
        $userId = Auth::id();
        $liked = $this->likeRepository->checkUserLiked($postId, $userId);
        return response()->json(['liked' => $liked]);
    }
}
