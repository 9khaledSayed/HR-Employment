<?php

namespace App\Http\Controllers\Dashboard;

use App\Conversation;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Message;
use App\Scopes\ParentScope;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_conversations');
        if($request->ajax()){
            $conversations = Conversation::with(['hr', 'employee'])->get();
            return response()->json($conversations);
        }
        return view('dashboard.conversations.index');
    }


    public function create()
    {
        $this->authorize('create_conversations');
        $employees = Employee::get();
        return view('dashboard.conversations.create', compact('employees'));
    }


    public function store(Request $request)
    {
        $this->authorize('create_conversations');
        $request['hr_id'] = auth()->user()->id;
        $conversation =  Conversation::firstOrCreate($request->validate([
            'employee_id' => 'required|numeric|exists:employees,id',
            'hr_id' => 'required|numeric|exists:employees,id',
        ]));
        return redirect(route('dashboard.conversations.show', $conversation->id));

    }


    public function show(Conversation $conversation)
    {
        $this->authorize('show_conversations');
        $receiver_id = (auth()->user()->id == $conversation->hr_id)?$conversation->employee_id:$conversation->hr_id;
        $receiver = Employee::withoutGlobalScope(ParentScope::class)->find($receiver_id);
//        dd($receiver->name);
        $messages = Message::with(['receiver', 'sender'])->where('conversation_id', $conversation->id)->get();
        return view('dashboard.conversations.show', compact('messages','conversation', 'receiver'));
    }


    public function destroy(Request $request, Conversation $conversation)
    {
        $this->authorize('delete_conversations');
        if($request->ajax()){
            $conversation->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.conversations.index'));
    }
}
