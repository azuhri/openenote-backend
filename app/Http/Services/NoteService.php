<?php

namespace App\Http\Services;

use App\Http\Repositories\NoteRepository;
use Exception;
use Illuminate\Http\Request;

class NoteService {
    public NoteRepository $noteRepository;
    public JsonServices $json;
    public function __construct(NoteRepository $noteRepo, JsonServices $json)
    {
        $this->noteRepository = $noteRepo;
        $this->json = $json;
    }

    public function createNote(Request $request, $userId)  {
        $newNote = $this->noteRepository->createNote($request, $userId);
        return $this->json->responseDataWithMessage($newNote, "success create new note");
    }

    public function getAllNote($userId) {
        if((count($notes = $this->noteRepository->getAllNote($userId)) == 0)) 
            throw new Exception("Data not note not found");
        
        return $this->json->responseData($notes);
    }

    public function getNoteById($noteId) {
        if(!($note = $this->noteRepository->getNoteById($noteId))) 
            throw new Exception("Data not note not found");

        return $this->json->responseData($note);
    }

    public function updateShare($shareType, $noteId) {
        if(!$this->noteRepository->getNoteById($noteId))
            throw new Exception("data note not found");

        $note = $this->noteRepository->updateShareTypeNote($shareType, $noteId);
        return $this->json->responseDataWithMessage($note, "success update share link");
    }
}