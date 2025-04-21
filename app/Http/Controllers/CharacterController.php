<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Origin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $characters = Character::all();
        return view('listCharacters', compact('characters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'characters' => 'required',
            'characters.*.id' => 'required|string',
            'characters.*.name' => 'required|string',
            'characters.*.status' => 'required|string',
            'characters.*.species' => 'required|string',
            'characters.*.image' => 'required|string',
            'characters.*.gender' => 'required|string'
        ]);
        $characters = json_decode($request->input('characters'), true);
        DB::beginTransaction();
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Desactivo momentaneamente la revision de foraneas debido a que me genero varios errores al querer truncar la tabla origins
            Character::truncate();
            Origin::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            foreach ($characters as $character) {
                $characterOrigin = Origin::firstOrCreate([
                    'name' => $character['origin']['name'],
                    'url' => empty($character['origin']['url'])?null:$character['origin']['url']
                ]);
                Character::create([
                    'id' => $character['id'],
                    'name' => $character['name'],
                    'status' => strtolower($character['status']),
                    'species' => strtolower($character['species']),
                    'image' => $character['image'],
                    'type' => empty($character['type'])?null:$character['type'],
                    'gender' => strtolower($character['gender']),
                    'fk_origin' => $characterOrigin->id,
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return new JsonResponse(['status' => 0, 'msg' => 'An error occurred while saving the records.', 'error' => $e->getMessage()]);
        }
        return new JsonResponse(['status' => 1, 'msg' => 'Data saved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $character = Character::with('origin')->findOrFail($request->get('id'));
        return view('modals._editModal', compact('character'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|int',
            'name' => 'required|string',
            'status' => 'required|string',
            'species' => 'required|string',
            'image' => 'required|string',
            'gender' => 'required|string',
            'orName' => 'required|string'
        ]);
        DB::beginTransaction();
        try {
            $characterOrigin = Origin::firstOrCreate([
                'name' => $request->input('orName'),
                'url' => empty($request->input('orURL'))?null:$request->input('orURL')
            ]);
            $character = Character::findOrFail($request->input('id'));
            $character->update([
                'name' => $request->input('name'),
                'status' => strtolower($request->input('status')),
                'species' => strtolower($request->input('species')),
                'image' => $request->input('image'),
                'type' => empty($request->input('type'))?null:$request->input('type'),
                'gender' => strtolower($request->input('gender')),
                'fk_origin' => $characterOrigin->id,
            ]);
            DB::commit();
            return new JsonResponse(['status' => 1, 'msg' => 'Character updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return new JsonResponse(['status' => 0, 'msg' => 'An error occurred while updating the record.', 'error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|int',
        ]);
        DB::beginTransaction();
        try {
            $character = Character::findOrFail($request->input('id'));
            $character->delete();
            DB::commit();
            return new JsonResponse(['status' => 1, 'msg' => 'Character deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return new JsonResponse(['status' => 0, 'msg' => 'An error occurred while deleting the record.', 'error' => $e->getMessage()]);
        }
    }
}
