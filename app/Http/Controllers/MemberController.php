<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /* ================= INDEX ================= */
    public function index()
    {
        $members = DB::table('members')
            ->join('users', 'members.user_id', '=', 'users.id')
            ->select(
                'members.id as id',
                'members.user_id',
                'users.username',
                'users.email',
                'members.membership_no',
                'members.created_at'
            )
            ->get();

        return view('admin.members', compact('members'));
    }

    /* ================= CREATE (Register Member Page) ================= */
    public function create()
    {
        $users = User::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('members')
                ->whereRaw('members.user_id = users.id');
        })->get();

        $latest = DB::table('members')->latest('id')->first();
        $num = $latest ? (int)substr($latest->membership_no, 3) + 1 : 1;
        $newMembershipNo = 'MBR' . str_pad($num, 3, '0', STR_PAD_LEFT);

        return view('admin.create-member', compact('users', 'newMembershipNo'));
    }

    /* ================= STORE EXISTING USER ================= */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_no' => 'required|unique:members,membership_no',
        ]);

        Member::create([
            'user_id' => $request->user_id,
            'membership_no' => $request->membership_no,
        ]);

        return redirect()->route('members.index')->with('success', 'Member added successfully!');
    }

    /* ================= REGISTER NEW USER ================= */
    public function registerAndStore(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
        ]);

        $latest = Member::latest()->first();
        $num = $latest ? (int)substr($latest->membership_no, 3) + 1 : 1;

        Member::create([
            'user_id' => $user->id,
            'membership_no' => 'MBR' . str_pad($num, 3, '0', STR_PAD_LEFT),
        ]);

        return redirect()->route('members.index')->with('success', 'Member registered successfully!');
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $member = DB::table('members')
            ->join('users', 'members.user_id', '=', 'users.id')
            ->select(
                'members.id',
                'members.user_id',
                'members.membership_no',
                'users.username',
                'users.email'
            )
            ->where('members.id', $id)
            ->first();

        return view('admin.member-edit', compact('member'));
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, $id)
    {
        $member = DB::table('members')->where('id', $id)->first();

        if (!$member) {
            return redirect()->route('members.index')->with('error', 'Member not found');
        }

        DB::table('members')
            ->where('id', $id)
            ->update(['membership_no' => $request->membership_no]);

        DB::table('users')
            ->where('id', $member->user_id)
            ->update([
                'username' => $request->username,
                'email' => $request->email
            ]);

        return redirect()->route('members.index')->with('success', 'Member updated successfully!');
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $member = DB::table('members')->where('id', $id)->first();

        if ($member) {
            DB::table('members')->where('id', $id)->delete();
            DB::table('users')->where('id', $member->user_id)->delete();
        }

        return redirect()->route('members.index')->with('success', 'Member deleted successfully!');
    }
}