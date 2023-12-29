<?php

namespace App\Http\Repositories\Interfaces;

use Illuminate\Http\Request;

interface InterfaceNoteRepository {
    public function createNote(Request $request, $userId);
    public function getAllNote($userId);
    public function getNoteById($noteId);
    public function updateShareTypeNote($shareType, $noteId);
}