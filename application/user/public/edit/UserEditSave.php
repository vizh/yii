<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('library.graphics.*');
AutoLoader::Import('library.rocid.activity.userchanges.*');


class UserEditSave extends AjaxAuthCommand
{
	private $tag = '';
	private $result = array();
	protected function doExecute()
	{
		if ($this->LoginUser == null)
		{
			echo json_encode(array('error' => true));
			exit;
		}
		$this->tag = Registry::GetRequestVar('tag');
		$this->result['tag'] = $this->tag;

    $errors = Registry::GetWord('error');
    $this->result['message'] = $errors['notsave'] . ' ' . $errors['required'];

		$data = Registry::GetRequestVar('data');
		switch ($this->tag)
		{
			case 'main':
				$this->processMainData($data);
				break;
			case 'AddJob':
				$this->addNewJob($data);
				break;
			case 'DeleteJob':
				$this->deleteJob($data);
				break;
			case 'work':
				$this->processWorkData($data);
				break;
			case 'contact':
				$this->processContactData($data);
				break;
			case 'DeleteContact':
				$this->deleteContact($data);
				break;
			case 'address':
				$this->processAddressData($data);
				break;
			case 'addphoto':
				$this->addPhoto();
				break;
			case 'settings':
				$this->processSettingsData($data);
				break;
			case 'ResizePhoto':
				$this->resizePhoto($data);
				break;
			case 'DeletePhoto':
				$this->deletePhoto($data);
				break;
      case 'ChangePassword':
        $this->changePassword($data);
        break;
      case 'ChangeEmail':
        $this->changeEmail($data);
        break;
			default:
		}
		echo json_encode($this->result);
	}

	private function processMainData($data)
	{
		$user = $this->LoginUser;
		$user->Sex = intval($data['gender']);
    $purifier = new CHtmlPurifier();
    $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');
		$user->FirstName = $purifier->purify($data['name']);
		$user->LastName = $purifier->purify($data['lastname']);
		$user->FatherName = $purifier->purify($data['fathername']);
                $user->Settings->HideFatherName = (int) $data['hidefathername'] == 0 ? 0 : 1;
                $user->Settings->HideBirthdayYear = (int) $data['hidebirthdayyear'] == 0 ? 0 : 1;
                
                if ( empty($user->LastName) || empty($user->FirstName))
                {
                    $this->result['error'] = true;
                    $errors = Registry::GetWord('error');
                    $this->result['message'] = $errors['notsave'] . ' ' . $errors['fio'];
                    return;
                }

		$user->SetParsedBirthday(array('day' => intval($data['bday']),
																	'month' => intval($data['bmonth']), 'year' => intval($data['byear'])));
		$user->save();
		$user->Settings->save();
                
                $this->result['error'] = false;
	}

	private function deleteJob($data)
	{
		$id = intval($data);
		$this->result['id'] = $id;

		$employments = $this->LoginUser->GetEmployments();
		$deleteEmployment = null;
		foreach($employments as $employment)
		{
			if ($employment->EmploymentId == $id)
			{
				$deleteEmployment = $employment;
				break;
			}
		}

		if ($deleteEmployment == null)
		{
			$this->result['error'] = true;
		}
		else
		{
			$deleteEmployment->delete();
			$this->result['error'] = false;
		}    
	}

	private function processWorkData($data)
	{
		//var_dump($data);
		if (empty($data))
		{
			return;
		}
		if (!$this->checkWorkData($data))
		{
			return;
		}

    $purifier = new CHtmlPurifier();
    $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');

    UserEmployment::ResetAllUserPrimary($this->LoginUser->UserId);
		$employments = $this->LoginUser->GetEmployments();
    $oldIds = array();
		foreach ($employments as $employment)
		{
			if (isset($data[$employment->EmploymentId]))
			{
        $oldIds[] = $employment->EmploymentId;
				$new = $data[$employment->EmploymentId];
				$company = $employment->Company;

				if (empty($company) || $company->Name != $new['company'])
				{
          $company = Company::GetCompanyByName($new['company']);
          if (empty($company))
          {
            $company = new Company();
					  $company->Name = $purifier->purify($new['company']);
					  $company->CreationTime = time();
					  $company->save();
          }
				}

				$start = preg_split('/\./', trim($new['start']), -1, PREG_SPLIT_NO_EMPTY);
				$end = preg_split('/\./', trim($new['end']), -1, PREG_SPLIT_NO_EMPTY);
				$start[0] = isset($start[0]) ? intval($start[0]) : 0;
				$start[1] = isset($start[1]) ? intval($start[1]) : 0;
				$end[0] = isset($end[0]) ? intval($end[0]) : 0;
				$end[1] = isset($end[1]) ? intval($end[1]) : 0;

				$employment->CompanyId = $company->CompanyId;
				$employment->SetParsedStartWorking(array('year'=>$start[1], 'month'=>$start[0]));
				$employment->SetParsedFinishWorking(array('year'=>$end[1], 'month'=>$end[0]));
				$employment->Position = $purifier->purify($new['position']);
				$employment->Primary = $new['primary'] == '1' ? 1 : 0;
				$employment->save();
			}
		}
    $result = array();
    foreach ($data as $key => $value)
    {
      if (! in_array($key, $oldIds))
      {
        $employment = $this->addNewJob($value);
        $result[$key] = $employment->EmploymentId;
      }
    }

    $this->result['newjobs'] = $result;
		$this->result['error'] = false;
	}

	private function checkWorkData($data)
	{
		foreach ($data as $key => $value)
		{
			if (empty($value['company']) || empty($value['position']))
			{
				$this->result['error'] = true;
				$this->result['error_id'] = $key;
				return false;
			}
			$start = preg_split('/\./', trim($value['start']), -1, PREG_SPLIT_NO_EMPTY);
			$end = preg_split('/\./', trim($value['end']), -1, PREG_SPLIT_NO_EMPTY);
			$start[0] = isset($start[0]) ? intval($start[0]) : 0;
			$start[1] = isset($start[1]) ? intval($start[1]) : 0;
			$end[0] = isset($end[0]) ? intval($end[0]) : 0;
			$end[1] = isset($end[1]) ? intval($end[1]) : 0;
			if ($start[1] == 0 || $end[0] != 0 && $end[1] == 0)
			{
				$this->result['error'] = true;
				$this->result['error_id'] = $key;
				return false;
			}
		}

		return true;
	}

  private function addNewJob($data)
	{
		$start = preg_split('/\./', trim($data['start']), -1, PREG_SPLIT_NO_EMPTY);
		$end = preg_split('/\./', trim($data['end']), -1, PREG_SPLIT_NO_EMPTY);
		$start[0] = isset($start[0]) ? intval($start[0]) : 0;
		$start[1] = isset($start[1]) ? intval($start[1]) : 0;
		$end[0] = isset($end[0]) ? intval($end[0]) : 0;
		$end[1] = isset($end[1]) ? intval($end[1]) : 0;

		$company = Company::GetCompanyByName($data['company']);

    $purifier = new CHtmlPurifier();
    $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');

		if ($company == null)
		{
			$company = new Company();
			$company->Name = $purifier->purify($data['company']);
			$company->CreationTime = time();
			$company->save();
		}

		$userEmployment = new UserEmployment();

		$userEmployment->UserId = $this->LoginUser->UserId;
		$userEmployment->CompanyId = $company->CompanyId;
		$userEmployment->SetParsedStartWorking(array('year'=>$start[1], 'month'=>$start[0]));
		$userEmployment->SetParsedFinishWorking(array('year'=>$end[1], 'month'=>$end[0]));
		$userEmployment->Position = $purifier->purify($data['position']);
		$userEmployment->Primary = $data['primary'] == '1' ? 1 : 0;
		$userEmployment->save();

		UserChangeWork::Add($this->LoginUser->UserId, $company->CompanyId, $company->Name,
			$userEmployment->StartWorking, $userEmployment->FinishWorking);

    return $userEmployment;
	}

	private function processContactData($data)
	{
		$words = Registry::GetWord('edituser');
    $errors = Registry::GetWord('error');


		//Сохранение email
    $purifier = new CHtmlPurifier();
    $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');
    $data['email'] = $purifier->purify($data['email']);
		if (empty($data['email']) || $data['email'] == $words['emailtext'])
		{
			$this->result['error'] = true;
      $this->result['message'] = $errors['notsave'] . ' ' . $errors['required-email'];
			return;
		}
    $validator = new CEmailValidator();
    if (! $validator->validateValue($data['email']))
    {
      $this->result['error'] = true;
      $this->result['message'] = $errors['notsave'] . ' ' . $errors['wrong-email'];
			return;
    }
		$email = $this->LoginUser->GetEmail();
    if (empty($email))
    {
      $this->LoginUser->AddEmail($data['email'], 1, 1);
    }
    else
    {
      $email->Email = $data['email'];
      $email->save();
    }



		//Сохранение сайта/сайтов
    $data['site'] = $purifier->purify($data['site']);

    $sites = $this->LoginUser->Sites;
    $data['site'] = preg_replace('/http:\/\//', '', $data['site']);
    $parts = preg_split('/ /', trim($data['site']), -1, PREG_SPLIT_NO_EMPTY);
    $parts = array_slice($parts, 0, 3);
    foreach ($sites as $site)
    {
      $flag = false;
      foreach ($parts as $key => $url)
      {
        if ($site->Url == $url)
        {
          $flag = true;
          unset($parts[$key]);
          break;
        }
      }
      if (! $flag)
      {
        $this->LoginUser->DeleteSite($site);
        $site->delete();
      }
    }
    foreach ($parts as $url)
    {
      $site = new ContactSite();
      $site->Url = $url;
      $site->CreationTime = time();
      $site->save();

      $this->LoginUser->AddSite($site);

      UserChangeContact::Add($this->LoginUser->UserId, $site->Url, 0, 'site');

    }


		//Сохранение контактов
		$contacts = $this->LoginUser->GetServiceAccounts();
		foreach ($contacts as $contact)
		{
			foreach ($data['contacts'] as $key => $value)
			{
				$id = intval($key);
        $value['value'] = $purifier->purify($value['value']);
        $value['type'] = intval($value['type']);
				if ($id != 0)
				{
					if ($id == $contact->ServiceId  && ! empty($value['value']))
					{
						$contact->ServiceTypeId = $value['type'];
						if ($contact->Account != $value['value'])
						{
							UserChangeContact::Add($this->LoginUser->UserId, $value['value'], $value['type'], 'service');
						}
						$contact->Account = $value['value'];
						$contact->save();
					}
				}
				elseif (strpos($key, 'fb') !== false)
				{
					$id = intval(preg_replace('/fb/', '', $key));
					if ($id != 0 && $id == $contact->ServiceId)
					{
						if ($contact->Account != $value['value'])
						{
							UserChangeContact::Add($this->LoginUser->UserId, $value['value'], $value['type'], 'service');
						}
						$contact->Account = $value['value'];
						$contact->save();
					}
				}
				elseif (strpos($key, 'twi') !== false)
				{
					$id = intval(preg_replace('/twi/', '', $key));
					if ($id != 0 && $id == $contact->ServiceId)
					{
						if ($contact->Account != $value['value'])
						{
							UserChangeContact::Add($this->LoginUser->UserId, $value['value'], $value['type'], 'service');
						}
						$contact->Account = $value['value'];
						$contact->save();
					}
				}
			}
		}
		$contactsContainer = new ViewContainer();
		$serviceTypes = ContactServiceType::GetAll();
		foreach ($data['contacts'] as $key => $value)
		{
      $value['value'] = $purifier->purify($value['value']);
      $value['type'] = intval($value['type']);
			if ((strpos($key, 'new') !== false || $key == 'fb' || $key == 'twi') && ! empty($value['value']))
			{
				$contact = new ContactServiceAccount();
				$contact->ServiceTypeId = $value['type'];
				$contact->Account = $value['value'];
				$contact->save();

				UserChangeContact::Add($this->LoginUser->UserId, $value['value'], $value['type'], 'service');


				$this->LoginUser->AddServiceAccount($contact);

				if ($key == 'fb' || $key == 'twi')
				{
					$this->result[$key] = $contact->ServiceId;
					continue;
				}

				$contactView = new View();
				$contactView->SetTemplate('messenger', 'user', 'edit', '');
				$contactView->ContactId = $contact->ServiceId;
				$contactView->Name = $contact->Account;
				$contactView->TypeId = $contact->ServiceTypeId;
				$contactView->ServiceTypes = $serviceTypes;
				$contactsContainer->AddView($contactView);
			}
		}


		if (empty($data['phones']))
		{
			$data['phones'] = array();
		}
		//Сохранение телефонов
		$phones = $this->LoginUser->GetPhones();
		foreach ($phones as $phone)
		{
			foreach ($data['phones'] as $key => $value)
			{
				$id = intval($key);
				if ($id != 0)
				{
					if ($id == $phone->PhoneId && ! empty($value['value']))
					{
            $value['type'] = $purifier->purify($value['type']);
            $value['value'] = $purifier->purify($value['value']);
						$phone->Type = $value['type'];
						$phone->Phone = $value['value'];
						$phone->save();
					}
				}
			}
		}
		$phonesContainer = new ViewContainer();
		foreach ($data['phones'] as $key => $value)
		{
			if ((strpos($key, 'new') !== false) && !empty($value['value']))
			{
        $value['type'] = $purifier->purify($value['type']);
        $value['value'] = $purifier->purify($value['value']);

				$phone = new ContactPhone();
				$phone->Type = $value['type'];
				$phone->Phone = $value['value'];
				$phone->save();

				$this->LoginUser->AddPhone($phone);

				$phoneView = new View();
				$phoneView->SetTemplate('phone', 'user', 'edit', '');
				$phoneView->Id = $phone->PhoneId;
				$phoneView->Phone = $phone->Phone;
				$phoneView->Type = $phone->Type;
				$phonesContainer->AddView($phoneView);
			}
		}

		$this->result['error'] = false;
		$this->result['contacts'] = $contactsContainer->__toString();
		$this->result['phones'] = $phonesContainer->__toString();
	}

	private function deleteContact($data)
	{
		$id = intval($data['id']);

		if ($data['type'] == 'contact')
		{
			$this->LoginUser->DeleteServiceAccount($id);
		}
		elseif ($data['type'] == 'phone')
		{
			$this->LoginUser->DeletePhone($id);
		}
		$this->result['type'] = $data['type'];
		$this->result['id'] = $id;
		$this->result['error'] = false;
	}

	private function processAddressData($data)
	{
		$address = $this->LoginUser->GetAddress();
		if ($address == null)
		{
			$address = new ContactAddress();
			$address->save();

			$this->LoginUser->AddAddress($address);
		}

		$address->CityId = intval($data['city']);
		$address->PostalIndex = $data['postalindex'];
		$address->Street = $data['street'];
		$address->SetHouseParsed(array($data['housenum'], $data['building'], $data['housing']));
		$address->Apartment = $data['apartment'];
		$address->save();

		$this->result['error'] = false;
	}

	private function addPhoto()
	{
		$path = $this->LoginUser->GetPhotoDir(true);
		if (! is_dir($path))
		{
			mkdir($path);
		}
		$namePrefix = $this->LoginUser->RocId;
		$clearSaveTo = $path . $namePrefix . '_clear.jpg';
		$result = Graphics::SaveImageFromPost('photo', $clearSaveTo);
		$newImage = $path . $namePrefix . '.jpg';
		$result &= Graphics::SaveImageFromPost('photo', $newImage);
		$newImage = $path . $namePrefix . '_200.jpg';
		$result &= Graphics::ResizeAndSave($clearSaveTo, $newImage, 200, 0, array('x1'=>0, 'y1'=>0));
		$newImage = $path . $namePrefix . '_90.jpg';
		$result &= Graphics::ResizeAndSave($clearSaveTo, $newImage, 90, 90, array('x1'=>0, 'y1'=>0));
		$newImage = $path . $namePrefix . '_50.jpg';
		$result &= Graphics::ResizeAndSave($clearSaveTo, $newImage, 50, 50, array('x1'=>0, 'y1'=>0));

		//$photoView = new View();
		//$photoView->SetTemplate('photoresize', 'user', 'edit', '');
		//$photoView->Photo = $this->LoginUser->GetPhoto();

		$this->result['image'] = $this->LoginUser->GetPhoto();
		$this->result['miniimage'] = $this->LoginUser->GetMiniPhoto();
		//$this->result['imageresize'] = $photoView->__toString();
		$this->result['error'] = false;

		//print_r($_FILES);
	}

	private function resizePhoto($data)
	{
		//print_r($data);
		$path = $this->LoginUser->GetPhotoDir(true);
		$namePrefix = $this->LoginUser->RocId;
		$clearSaveTo = $path . $namePrefix . '_200.jpg';

		$area = array('x1'=>$data['x1'], 'y1'=>$data['y1'],
									'x2'=>$data['x1'] + $data['width'], 'y2'=>$data['y1'] + $data['height']);
		$newImage = $path . $namePrefix . '_90.jpg';
		$result = Graphics::ResizeAndSave($clearSaveTo, $newImage, 90, 90, $area);
		$newImage = $path . $namePrefix . '_50.jpg';
		$result &= Graphics::ResizeAndSave($clearSaveTo, $newImage, 50, 50, $area);

		$this->result['image'] = $this->LoginUser->GetPhoto();
		$this->result['miniimage'] = $this->LoginUser->GetMiniPhoto();
		$this->result['error'] = false;
	}

	private function deletePhoto($data)
	{
		$path = $this->LoginUser->GetPhotoDir(true);
		if (! is_dir($path))
		{
			mkdir($path);
		}
		$namePrefix = $this->LoginUser->RocId;
		$clearSaveTo = $path . $namePrefix . '_clear.jpg';
		if (file_exists($clearSaveTo))
		{
			unlink($clearSaveTo);
		}
		$newImage = $path . $namePrefix . '.jpg';
		if (file_exists($newImage))
		{
			unlink($newImage);
		}
		$newImage = $path . $namePrefix . '_200.jpg';
		if (file_exists($newImage))
		{
			unlink($newImage);
		}
		$newImage = $path . $namePrefix . '_90.jpg';
		if (file_exists($newImage))
		{
			unlink($newImage);
		}
		$newImage = $path . $namePrefix . '_50.jpg';
		if (file_exists($newImage))
		{
			unlink($newImage);
		}

		$this->result['image'] = $this->LoginUser->GetPhoto();
		$this->result['miniimage'] = $this->LoginUser->GetMiniPhoto();
		$this->result['error'] = false;
	}


	private function processSettingsData($data)
	{
		$settings = $this->LoginUser->CreateSettings();
		$settings->ProjNews = (! empty($data['projnews'])) && $data['projnews'] != 0 ? 1 : 0;
		$settings->EventNews = (! empty($data['eventnews'])) && $data['eventnews'] != 0 ? 1 : 0;
		$settings->NoticePhoto = (! empty($data['noticephoto'])) && $data['noticephoto'] != 0 ? 1 : 0;
    $settings->IndexProfile = (! empty($data['indexprofile'])) && $data['indexprofile'] != 0 ? 0 : 1;
		$settings->save();

		$this->result['error'] = false;
	}

  private function changePassword($data)
  {
    if ($this->LoginUser->CheckLogin($this->LoginUser->RocId, trim($data['current_pass'])))
    {
      $data['new_pass'] = trim($data['new_pass']);
      $data['rnew_pass'] = trim($data['rnew_pass']);
      $errors = Registry::GetWord('error');
      if ($data['new_pass'] != $data['rnew_pass'])
      {
        $this->result['message'] = $errors['notsave'] . ' ' . $errors['wrong-password-r'];
        $this->result['error'] = true;
      }
      elseif (mb_strlen($data['new_pass'], 'utf-8') < User::PasswordLengthMin)
      {
        $this->result['message'] = $errors['notsave'] . ' ' . $errors['wrong-password-short'];
        $this->result['error'] = true;
      }
      else
      {
        $this->LoginUser->Password = User::GetPasswordHash($data['new_pass']);
        $this->LoginUser->save();
      }
    }
    else
    {
      $errors = Registry::GetWord('error');
      $this->result['message'] = $errors['notsave'] . ' ' . $errors['wrong-password'];
      $this->result['error'] = true;
    }
  }

  private function changeEmail($data)
  {
    if ($this->LoginUser->Email == trim($data['current_email']))
    {
      $data['new_email'] = trim($data['new_email']);
      $data['rnew_email'] = trim($data['rnew_email']);
      $errors = Registry::GetWord('error');
      $emailValidator = new CEmailValidator();
      if ($data['new_email'] != $data['rnew_email'])
      {
        $this->result['message'] = $errors['notsave'] . ' ' . $errors['wrong-email-r'];
        $this->result['error'] = true;
      }
      elseif ( !$emailValidator->validateValue($data['new_email']))
      {
        $this->result['message'] = $errors['notsave'] . ' ' . $errors['wrong-email'];
        $this->result['error'] = true;
      }
      else
      {
        $user = User::GetByEmail($data['new_email']);
        if (! empty($user))
        {
          $this->result['message'] = $errors['notsave'] . ' Пользователь с таким email уже существует';
          $this->result['error'] = true;
        }
        else
        {
          $this->LoginUser->Email = $data['new_email'];
          $this->LoginUser->save();
        }
      }
    }
    else
    {
      $errors = Registry::GetWord('error');
      $this->result['message'] = $errors['notsave'] . ' ' . $errors['wrong-email-current'];
      $this->result['error'] = true;
    }
  }

  private function deleteAccount($data)
  {

  }
}