<div data-role="content">
<ul data-role="listview" class="event-list" data-splittheme="f">
  <li data-role="list-divider" class="head-event">
    <h1>Список участников</h1>
  </li>
</ul>

  <div data-role="fieldcontain">
    <!--<form onsubmit="item = $('#usersearch', $(this))[0]; OnChangeUserSearch(item); alert('true'); return false;" method="post">-->
    <label for="usersearch" class="event-user-search-label">ФИО или rocID:</label>
    <input type="text" name="NameSeq" id="usersearch"
      eventidname="<?=$this->IdName?>" value="<?=htmlspecialchars($this->NameSeq);?>" onchange="OnChangeUserSearch(this);" />
    <!--</form>-->
  </div>
<ul data-role="listview" class="event-list" id="user-list" data-splittheme="f">  
  <?=$this->UserList; ?>
</ul>
</div>