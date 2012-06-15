<?php
AutoLoader::Import('library.rocid.attachment.IAttachmentPath');
class DefaultAttachmentPath implements IAttachmentPath
{
  public function GetPath($hash)
  {    
    $savePath = SettingManager::GetSetting('SavePath');
    return $savePath . '/' . $hash;
  }
}
