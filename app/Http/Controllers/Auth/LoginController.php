namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        // Regenerate the session to prevent session fixation
        $request->session()->regenerate();
        
        // If the request expects JSON (API), return a JSON response
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'redirect' => $this->redirectPath(),
                'user' => $user->only(['id', 'name', 'email', 'role'])
            ]);
        }

        // Redirect based on user role for web requests
        $redirectTo = match($user->role) {
            'admin' => route('admin.dashboard'),
            'staff' => route('staff.dashboard'),
            'user'  => route('dashboard'),
            default => null
        };

        if ($redirectTo) {
            return redirect()->intended($redirectTo);
        }

        Auth::logout();
        return $request->wantsJson()
            ? response()->json(['message' => 'Unauthorized access.'], 403)
            : redirect('/login')->with('error', 'Unauthorized access.');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => trans('auth.failed'),
                'errors' => [
                    'email' => [trans('auth.failed')],
                ]
            ], 422);
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => trans('auth.failed'),
            ]);
    }
}