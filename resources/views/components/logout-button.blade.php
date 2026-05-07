<form method="POST" action="{{route('logout')}}">
    @csrf
    <button type="submit" class="text-white">
        <i class="fa fa-sign-out"></i>Logout
    </button>
    <!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
</form>
