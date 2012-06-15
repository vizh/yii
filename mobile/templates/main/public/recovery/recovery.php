<div data-role="content" data-theme="f">  
<ul data-role="listview" class="event-list" data-splittheme="f">
  <li data-role="list-divider" class="head-event">
    <h1 class="normal-whitespace">Получение временного пароля</h1>
  </li>
</ul>
  <form action="/main/recovery/" method="post" >
    
    <div data-role="fieldcontain">
      <input type="hidden" name="formid" value="recovery">
      <label for="rocid">rocID</label>
      <input type="text" name="rocid" id="rocid" value="" data-theme="f" />
      
      <label for="email">email</label>
      <input type="text" name="email" id="email" value="" data-theme="f" />

      <button type="submit" data-theme="g">Получить</button>
      <a href="/" data-role="button">Отмена</a>
    </div>

  </form> 

</div>