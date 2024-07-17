<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role_id' => 'required|integer',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|integer',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function whatsapp($id)
    {
        $user = User::findOrFail($id);
        $lastRating = $user->ratings()->latest()->first();

        $ratingLevels = [
            '1' => 'المستوى الأول (مقبول)',
            '2' => 'المستوى الثاني (جيد)',
            '3' => 'المستوى الثالث (جيد جدا)',
            '4' => 'المستوى الرابع (ممتاز)',
        ];

        $message = "
            اهلا {$user->name},
            نود اعلامكم بتقيمكم الخاص بالفصل {$lastRating->branch->name} والمادة {$lastRating->subject->name} وهو كالتالي:
            التخطيط: {$ratingLevels[$lastRating->planning]}
            ادارة الصف: {$ratingLevels[$lastRating->manage_class]}
            استراتيجيات التعلم: {$ratingLevels[$lastRating->learning_strategy]}
            الوسائل: {$ratingLevels[$lastRating->media_usage]}
            التقويم: {$ratingLevels[$lastRating->homework]}
            البعد الأكاديمي: {$ratingLevels[$lastRating->academic_knowledge]}
            غرس القيم والمهارات الحياتية: {$ratingLevels[$lastRating->molars_and_skills]}
            شكرا لكم
        ";

        // Encode the message for URL
        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/2{$user->mobile}?text={$encodedMessage}";

        return Redirect::away($whatsappUrl);
    }
}
