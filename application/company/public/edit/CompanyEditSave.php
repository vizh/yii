<?php
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('library.graphics.*');


class CompanyEditSave extends AjaxAuthCommand
{
  /**
	 * @var Company
	 */
	private $company;

	private $tag = '';
	private $result = array();
	protected function doExecute($companyId = '')
	{
    $companyId = intval($companyId);
    $this->company = Company::GetById($companyId, Company::LoadMiddleInfo);

		if ($companyId === 0 || empty($this->LoginUser) || empty($this->company) ||
        !($this->LoginUser->IsHaveAdminPermissions() || $this->company->IsEditor($this->LoginUser)))
		{
			echo json_encode(array('error' => true));
			exit;
		}
    
		$this->tag = Registry::GetRequestVar('tag');
		$this->result['tag'] = $this->tag;
		$data = Registry::GetRequestVar('data');
		switch ($this->tag)
		{
			case 'main':
				$this->processMainData($data);
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
			case 'addlogo':
				$this->addLogo();
				break;
			case 'DeleteLogo':
				$this->deleteLogo($data);
				break;

			default:
		}
		echo json_encode($this->result);

	}

	private function processMainData($data)
	{
		if (empty($data['name']))
		{
			$this->result['error'] = true;
			return;
		}

    $purifier = new CHtmlPurifier();
    $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');

		$this->company->Name = $purifier->purify($data['name']);
		$this->company->FullName = $purifier->purify($data['fullname']);
		$this->company->Info = $purifier->purify($data['info']);

		$this->company->save();
		$this->result['error'] = false;
	}

	private function processContactData($data)
	{
		$words = Registry::GetWord('editcompany');
		//var_dump($data);
		//Сохранение email
/*		
		if ($data['email'] == $words['emailtext'])
		{
			$this->result['error'] = true;
			return;
		}
*/
    $purifier = new CHtmlPurifier();
    $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');

		$flagEmailDelete = false;
		$email = $this->company->GetEmail();
		if ($email == null)
		{
			$email = new ContactEmail();
			$email->save();
			$this->company->AddEmail($email);
		}
		else {
			if ($data['email'] == $words['emailtext'] || $data['email'] == '')
			{
				$flagEmailDelete = true;
			}
		}

		if ($flagEmailDelete) {
			$this->company->DeleteEmail($email);
			$email->delete();
		}
		else {
			$email->Email = $purifier->purify($data['email']);
			$email->save();
		}

		//Сохранение сайта/сайтов
		if ($data['site'] != $words['sitetext'])
		{
			$sites = $this->company->Sites;
      $data['site'] = $purifier->purify($data['site']);
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
					$this->company->DeleteSite($site);
					$site->delete();
				}
			}
      foreach ($parts as $url)
      {
        $site = new ContactSite();
        $site->Url = $url;
        $site->CreationTime = time();
        $site->save();

        $this->company->AddSite($site);
      }
		}

		//Сохранение телефонов
		if (empty($data['phones']))
		{
			$data['phones'] = array();
		}
		$phones = $this->company->GetPhones();
		foreach ($phones as $phone)
		{
			foreach ($data['phones'] as $key => $value)
			{
				$id = intval($key);
				if ($id != 0)
				{
					if ($id == $phone->PhoneId && ! empty($value['value']))
					{
						$phone->Type = $purifier->purify($value['type']);
						$phone->Phone = $purifier->purify($value['value']);
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
				$phone = new ContactPhone();
				$phone->Type = $purifier->purify($value['type']);
				$phone->Phone = $purifier->purify($value['value']);
				$phone->save();

				$this->company->AddPhone($phone);

				$phoneView = new View();
				$phoneView->SetTemplate('phone', 'company', 'edit', '');
				$phoneView->Id = $phone->PhoneId;
				$phoneView->Phone = $phone->Phone;
				$phoneView->Type = $phone->Type;
				$phonesContainer->AddView($phoneView);
			}
		}

		$this->result['error'] = false;
		$this->result['phones'] = $phonesContainer->__toString();
	}

	private function deleteContact($data)
	{
		$id = intval($data['id']);

		if ($data['type'] == 'phone')
		{
			$this->company->DeletePhone($id);
		}
		$this->result['type'] = $data['type'];
		$this->result['id'] = $id;
		$this->result['error'] = false;
	}

	private function processAddressData($data)
	{
    $purifier = new CHtmlPurifier();
    $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');

		$address = $this->company->GetAddress();
		if ($address == null)
		{
			$address = new ContactAddress();
			$address->save();

			$this->company->AddAddress($address);
		}

		$address->CityId = intval($data['city']);
		$address->PostalIndex = $purifier->purify($data['postalindex']);
		$address->Street = $purifier->purify($data['street']);
		$address->SetHouseParsed(array($purifier->purify($data['housenum']),
                                  $purifier->purify($data['building']), $purifier->purify($data['housing'])));
		$address->Apartment = $purifier->purify($data['apartment']);
		$address->save();

		$this->result['error'] = false;
	}

	private function addLogo()
	{
		
		$path = $this->company->GetBaseDir(true);
		
		if (! is_dir($path))
		{
			mkdir($path);
		}
		$namePrefix = $this->company->CompanyId;
		
		$clearSaveTo = $path . $namePrefix . '_clear.jpg';
		$result = Graphics::SaveImageFromPost('logo', $clearSaveTo);
		
		$newImage = $path . $namePrefix . '.jpg';
		$result &= Graphics::SaveImageFromPost('logo', $newImage);
		
		$newImage = $path . $namePrefix . '_200.jpg';
		$result &= Graphics::ResizeAndSave($clearSaveTo, $newImage, 200, 0, array('x1'=>0, 'y1'=>0));
		
		$newImage = $path . $namePrefix . '_50.jpg';
		$result &= Graphics::ResizeAndSave($clearSaveTo, $newImage, 50, 0, array('x1'=>0, 'y1'=>0));

		$this->result['image'] = $this->company->GetLogo();
		$this->result['miniimage'] = $this->company->GetMiniLogo();
		$this->result['error'] = false;

//		print_r($_FILES);
	}

	private function deleteLogo($data)
	{
		$path = $this->company->GetBaseDir(true);
		if (! is_dir($path))
		{
			mkdir($path);
		}
		$namePrefix = $this->company->CompanyId;
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

		$newImage = $path . $namePrefix . '_50.jpg';
		if (file_exists($newImage))
		{
			unlink($newImage);
		}

		$this->result['image'] = $this->company->GetLogo();
		$this->result['miniimage'] = $this->company->GetMiniLogo();
		$this->result['error'] = false;
	}

}