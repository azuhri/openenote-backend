<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\InterfaceNoteRepository;
use App\Models\Note;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class NoteRepository implements InterfaceNoteRepository {

    public function createNote(Request $request, $userId)
    {
        $faker = Faker::create("id_ID");
        return Note::create([
            "id" => $faker->uuid(),
            "user_id" => $userId,
            "title" => $request->title,
            "content" => $request->content,
            "public_can_edit_link" => $faker->bothify("###########??????????"),
            "public_show_link" => $faker->bothify("###########??????????"),
        ]);
    }

    public function getAllNote($userId)
    {
        return Note::where("user_id", $userId)
                    ->orderBy("created_at","DESC")
                    ->get();
    }

    public function getNoteById($noteId)
    {
        return Note::find($noteId);
    }
    
    public function updateShareTypeNote($shareType, $noteId)
    {
        $findNote = Note::find($noteId);
        $findNote->share_type = $shareType;
        $findNote->update();
        return $findNote;
    }
}