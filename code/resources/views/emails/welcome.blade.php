Hello {{$user->full_name}}, welcome to B3Albania.
Thank you for creating an account. Please verify your email using this link:
{{route('verify', ['token' => $user->verification_token])}}
