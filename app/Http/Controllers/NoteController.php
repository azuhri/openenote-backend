<?php

namespace App\Http\Controllers;

use App\Http\Services\JsonServices;
use App\Http\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NoteController extends Controller
{
    public NoteService $service;
    public JsonServices $json;

    public function __construct(NoteService $noteService, JsonServices $json)
    {
        $this->service = $noteService;
        $this->json = $json;
    }

    function createNewNote(Request $request) {
        try {
            $request->validate([
                "title" => ["required","max:240"],
                "content" => ["required"],
            ]);
            return $this->service->createNote($request, Auth::id());
        } catch (\Throwable $th) {
            return $this->json->responseError($th->getMessage());
        }
    }

    public function getAllNote() {
        try {
            return $this->service->getAllNote(Auth::id());
        } catch (\Throwable $th) {
            return $this->json->responseError($th->getMessage());
        }
    }

    public function getNoteById($noteId) {
        try {
            return $this->service->getNoteById($noteId);
        } catch (\Throwable $th) {
            return $this->json->responseError($th->getMessage());
        }
    }

    public function shareLink(Request $request, $noteId) {
        try {
            $request->validate([
                "share_type" => ["required", Rule::in(["off","show","edit"])]
            ]);
            return $this->service->updateShare($request->share_type, $noteId);
        } catch (\Throwable $th) {
            return $this->json->responseError($th->getMessage());
        }
    }
}
