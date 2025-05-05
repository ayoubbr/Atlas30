<?php

namespace App\Http\Controllers;

use App\Repository\Impl\ICommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $commentRepository;

    public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(Request $request, $groupId, $postId)
    {
        $validated = $request->validate([
            'content' => 'required'
        ]);

        $this->commentRepository->createComment($validated['content'], Auth::id(), $postId);

        return redirect()->route('forum.post', ['groupId' => $groupId, 'postId' => $postId])
            ->with('success', 'Comment added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required'
        ]);

        $result = $this->commentRepository->updateComment($id, $validated['content']);

        if (!$result) {
            return redirect()->back()->with('error', 'Failed to update comment.');
        }

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    public function destroy($id)
    {
        $result = $this->commentRepository->deleteComment($id);

        if (!$result) {
            return redirect()->back()->with('error', 'Failed to delete comment.');
        }

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    public function getRecentComments()
    {
        $recentComments = $this->commentRepository->getRecentComments();
        return response()->json($recentComments);
    }

    public function getMonthlyCommentData()
    {
        $monthlyData = $this->commentRepository->getMonthlyCommentData();
        return response()->json($monthlyData);
    }
}
