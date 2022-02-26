<form action="{{route('login')}}" method="POST">
    @csrf
    <input type="tel" name="phone" placeholder="your phone number" required value="12345678"><br>
    <input type="password" name="password" placeholder="your phone number" required value="12345678"><br>

    <input type="submit" value="submit">


</form>
