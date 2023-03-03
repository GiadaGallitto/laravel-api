<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $rules;
    public $messages;

    public function __construct()
    {
        $this->rules = [
            'title' => 'required|min:5|max:15|unique:projects',
            'description' => 'required|min:15',
            'author' => 'required',
            'argument' => 'required|min:5|max:100',
            'start_date' => 'required',
            'image' => 'required',
            'type_id' => 'required|exists:types,id',
            'technologies' => 'array|exists:technologies,id',
        ];

        $this->messages = [
            'title.required' => 'Inserire un titolo',
            'title.min' => 'Il titolo è troppo corto',
            'title.max' => 'Ridurre i caratteri del titolo',
            'title.unique' => 'Questo progetto è già presente nell\' archivio',

            'description.required' => 'E\' necessaria una descrizione',
            'description.min' => 'Lunghezza insufficente per la descrizione',

            'author.required' => 'E\' necessario un autore',

            'argument.required' => 'Inserire l\'argomento',
            'argument.min' => 'Argomento troppo corto',
            'argument.max' => 'Ridurre la lunghezza dell\'argomento',

            'start_date.required' => 'E\' necessaria una data',

            'image.required' =>'Inserire un immagine',

            'type_id.required' => 'E\' necessaria una tipologia',
        ];
    }

    public function index()
    {
        $projects = Project::orderBy('start_date', 'DESC')->paginate(20);
        
        $trashed = Project::onlyTrashed()->get()->count();
        return view('admin.projects.index', compact('projects', 'trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $project = new Project();
        return view('admin.projects.create', ['project'=>new Project(), 'types'=> Type::all(), 'technologies'=>Technology::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if (!array_key_exists('concluded', $data)) {
            $data['concluded'] = false;
        }

        $request->validate($this->rules, $this->messages);

        $data['author'] = Auth::user()->name;
        $data['slug'] = Str::slug($data['title']);
        $data['image'] = Storage::put('imgs/', $data['image']);

        $newProject = new Project();
        $newProject->fill($data);
        $newProject->technologies()->sync($data['technologies'] ?? []);
        $newProject->save();

        return redirect()->route('admin.projects.index')->with('message', "The project $newProject->title has been created succesfully")->with('message_class', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $nextButton = Project::where('start_date', '<', $project->start_date)->orderBy('start_date', 'DESC')->first();

        $previousButton = Project::where('start_date', '>', $project->start_date)->orderBy('start_date')->first();

        return view('admin.projects.show', compact('project', 'nextButton', 'previousButton'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', ['project'=> $project, 'types'=> Type::all(), 'technologies'=>Technology::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $formData = $request->all();

        $newRules = $this->rules;
        $newRules['title'] = ['required', 'min:5', 'max:15', Rule::unique('projects')->ignore($project->id)];

        $request->validate($newRules, $this->messages);

        if (!array_key_exists('concluded', $formData)) {
            $formData['concluded'] = false;
        }

        if($project->isImageUrl()){
            Storage::delete($project->image);
        }

        $project->technologies()->sync($formData['technologies'] ?? []);
        $project->update($formData);
        return redirect()->route('admin.projects.index', compact('project'))->with('message', "The project $project->title has been updated succesfully")->with('alert-type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if($project->isImageUrl()){
            Storage::delete($project->image);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', "The project $project->title has been moved to the bin")->with('alert-type', 'warning');
    }

    public function trashed()
    {

        $projects = Project::onlyTrashed()->get();
        return view('admin.projects.trashed', compact('projects'));
    }

    public function forceDelete($slug)
    {
        Project::where('slug', $slug)->withTrashed()->forceDelete();
        return redirect()->route('admin.projects.trashed')->with('message', "The project $slug has been deleted definitely")->with('alert-type', 'warning');
    }

    public function restoreAll()
    {
        Project::onlyTrashed()->restore();
        return redirect()->route('admin.projects.index')->with('message', "All projects have been successfully restored")->with('alert-type', 'success');
    }

    public function restore( $slug)
    {
        Project::where('slug', $slug)->withTrashed()->restore();
        return redirect()->route('admin.projects.trashed')->with('message', "The project $slug has been successfully restored")->with('alert-type', 'success');
    }

    public function enableToggle(Project $project)
    {
        $project->concluded = !$project->concluded;
        $project->save();

        $message = ($project->concluded) ? "concluded" : "not-concluded";
        return redirect()->back()->with('alert-type', 'success')->with('alert-message', "$project->title:&nbsp;<b>$message</b>");
    }
}
