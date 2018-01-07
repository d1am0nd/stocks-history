<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add a stock</title>
  </head>
  <body>
    <form method="POST" action="/addstock">
      {!! csrf_field() !!}
      <label>Symbol</label>
      <input type="text" name="symbol" placeholder="msft"/>
      <br/>
      <label>Name</label>
      <input type="text" name="name" placeholder="Microsoft"/>
      <br/>
      <label>Super secret password</label>
      <input type="password" name="password"/>
      <br/>
      <button type="submit">Submit</button>
    </form>
  </body>
</html>
