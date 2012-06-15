<?
/**
 * @var $comment CommentModel
 */
$comment = $this->Comment;
?>
<tr>
  <td>
    <?=$comment->User->RocId;?>&nbsp;
    <a target="_blank" href="<?=RouteRegistry::GetUrl('user', '', 'show', array('rocid' => $comment->User->RocId));?>"><?=$comment->User->FirstName;?>&nbsp;
    <?=$comment->User->LastName;?></a>
  </td>
  <td><?=$comment->Content;?></td>
  <td><?=$comment->PostDate;?></td>
  <td>
    <?if ($comment->Deleted == 1):?>
    <span style="color: #f00;">Удалено</span>
    <?else:?>
    <?endif;?>
  </td>
  <td>
    <?if ($comment->ObjectType == CommentModel::ObjectNews):?>
      <a target="_blank" title="Перейти на источник" class="button" href="<?=RouteRegistry::GetUrl('news', '', 'show', array('newslink' => $comment->ObjectId . '-test'));?>">
        <span class="home icon"></span>
      </a>
    <?elseif (! empty($this->Event)):?>
      <a target="_blank" title="Перейти на источник" class="button" href="<?=RouteRegistry::GetUrl('event', '', 'show', array('idName' => $this->Event->IdName));?>">
        <span class="home icon"></span>
      </a>
    <?endif;?>

    <a title="Удалить" class="button negative" href="<?=RouteRegistry::GetUrl('comment', '', 'delete', array('id' => $comment->CommentId));?>?backUrl=<?=urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);?>" onclick="javascript:return confirm('Вы уверены, что хотите удалить комментарий?');">
      <span class="trash icon"></span>
    </a>
  </td>
</tr>