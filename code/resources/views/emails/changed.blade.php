Hello {{$user->full_name}}
You just changed your email address. Please verify your new email using this link:
{{route('verify', ['token' => $user->verification_token])}}
