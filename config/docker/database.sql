--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.3
-- Dumped by pg_dump version 9.6.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET search_path = public, pg_catalog;

ALTER TABLE IF EXISTS ONLY public."ApiAccountQuotaByUserLog" DROP CONSTRAINT IF EXISTS "fk__ApiAccountQuotaByUserLog__User";
ALTER TABLE IF EXISTS ONLY public."ApiAccountQuotaByUserLog" DROP CONSTRAINT IF EXISTS "fk__ApiAccountQuotaByUserLog__ApiAccount";
ALTER TABLE IF EXISTS ONLY public."PaperlessMaterial" DROP CONSTRAINT IF EXISTS "fk_PaperlessMaterial_Event";
ALTER TABLE IF EXISTS ONLY public."PaperlessMaterialLinkUser" DROP CONSTRAINT IF EXISTS "fk_PaperlessMaterialLinkUser_User";
ALTER TABLE IF EXISTS ONLY public."PaperlessMaterialLinkUser" DROP CONSTRAINT IF EXISTS "fk_PaperlessMaterialLinkUser_Material";
ALTER TABLE IF EXISTS ONLY public."PaperlessMaterialLinkRole" DROP CONSTRAINT IF EXISTS "fk_PaperlessMaterialLinkRole_Role";
ALTER TABLE IF EXISTS ONLY public."PaperlessMaterialLinkRole" DROP CONSTRAINT IF EXISTS "fk_PaperlessMaterialLinkRole_Material";
ALTER TABLE IF EXISTS ONLY public."PaperlessEvent" DROP CONSTRAINT IF EXISTS "fk_PaperlessEvent_Event";
ALTER TABLE IF EXISTS ONLY public."PaperlessEventLinkRole" DROP CONSTRAINT IF EXISTS "fk_PaperlessEventLinkRole_Role";
ALTER TABLE IF EXISTS ONLY public."PaperlessEventLinkRole" DROP CONSTRAINT IF EXISTS "fk_PaperlessEventLinkRole_Event";
ALTER TABLE IF EXISTS ONLY public."PaperlessEventLinkMaterial" DROP CONSTRAINT IF EXISTS "fk_PaperlessEventLinkMaterial_Material";
ALTER TABLE IF EXISTS ONLY public."PaperlessEventLinkMaterial" DROP CONSTRAINT IF EXISTS "fk_PaperlessEventLinkMaterial_Event";
ALTER TABLE IF EXISTS ONLY public."PaperlessEventLinkDevice" DROP CONSTRAINT IF EXISTS "fk_PaperlessEventLinkDevice_Event";
ALTER TABLE IF EXISTS ONLY public."PaperlessEventLinkDevice" DROP CONSTRAINT IF EXISTS "fk_PaperlessEventLinkDevice_Device";
ALTER TABLE IF EXISTS ONLY public."PaperlessDevice" DROP CONSTRAINT IF EXISTS "fk_PaperlessDevice_Event";
ALTER TABLE IF EXISTS ONLY public."PaperlessDeviceSignal" DROP CONSTRAINT IF EXISTS "fk_PaperlessDeviceSignal_Device";
ALTER TABLE IF EXISTS ONLY public."EventMeetingPlace" DROP CONSTRAINT IF EXISTS "fk_EventMeetingPlace_parent";
ALTER TABLE IF EXISTS ONLY public."EventMeetingPlace" DROP CONSTRAINT IF EXISTS "fk_EventMeetingPlace_Event";
ALTER TABLE IF EXISTS ONLY public."ConnectMeeting" DROP CONSTRAINT IF EXISTS "fk_ConnectMeeting_User__Creator";
ALTER TABLE IF EXISTS ONLY public."ConnectMeeting" DROP CONSTRAINT IF EXISTS "fk_ConnectMeeting_EventMeetingPlace";
ALTER TABLE IF EXISTS ONLY public."EventUserData" DROP CONSTRAINT IF EXISTS eventuserdata_event_id_fk;
ALTER TABLE IF EXISTS ONLY public."User" DROP CONSTRAINT IF EXISTS "User_MergeUserId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserSettings" DROP CONSTRAINT IF EXISTS "UserSettings_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserReferral" DROP CONSTRAINT IF EXISTS "UserReferral_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserReferral" DROP CONSTRAINT IF EXISTS "UserReferral_ReferrerUserId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserReferral" DROP CONSTRAINT IF EXISTS "UserReferral_EventId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserEmployment" DROP CONSTRAINT IF EXISTS "UserEmployment_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserEducation" DROP CONSTRAINT IF EXISTS "UserEducation_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserEducation" DROP CONSTRAINT IF EXISTS "UserEducation_UniversityId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserEducation" DROP CONSTRAINT IF EXISTS "UserEducation_FacultyId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserDocument" DROP CONSTRAINT IF EXISTS "UserDocument_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserDocument" DROP CONSTRAINT IF EXISTS "UserDocument_TypeId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserDevice" DROP CONSTRAINT IF EXISTS "UserDevice_UserId_fKey";
ALTER TABLE IF EXISTS ONLY public."RuventsVisit" DROP CONSTRAINT IF EXISTS "RuventsVisit_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."RuventsVisit" DROP CONSTRAINT IF EXISTS "RuventsVisit_EventId_fkey";
ALTER TABLE IF EXISTS ONLY public."RuventsSetting" DROP CONSTRAINT IF EXISTS "RuventsSetting_EventId_fkey";
ALTER TABLE IF EXISTS ONLY public."RaecCompanyUser" DROP CONSTRAINT IF EXISTS "RaecCompanyUser_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."RaecCompanyUser" DROP CONSTRAINT IF EXISTS "RaecCompanyUser_StatusId_fkey";
ALTER TABLE IF EXISTS ONLY public."RaecCompanyUser" DROP CONSTRAINT IF EXISTS "RaecCompanyUser_CompanyId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayRoomPartnerOrder" DROP CONSTRAINT IF EXISTS "PayRoomPartnerOrder_EventId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayReferralDiscount" DROP CONSTRAINT IF EXISTS "PayReferralDiscount_ProductId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayReferralDiscount" DROP CONSTRAINT IF EXISTS "PayReferralDiscount_EventId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayProductPrice" DROP CONSTRAINT IF EXISTS "PayProductPrice_ProductId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayProductCheck" DROP CONSTRAINT IF EXISTS "PayProductCheck_OperatorId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderLinkOrderItem" DROP CONSTRAINT IF EXISTS "PayOrderLinkOrderItem_OrderItemId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderLinkOrderItem" DROP CONSTRAINT IF EXISTS "PayOrderLinkOrderItem_OrderId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderImportOrder" DROP CONSTRAINT IF EXISTS "PayOrderImportOrder_OrderId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderImportOrder" DROP CONSTRAINT IF EXISTS "PayOrderImportOrder_EntryId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderImportEntry" DROP CONSTRAINT IF EXISTS "PayOrderImportEntry_ImportId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayFoodPartnerOrder" DROP CONSTRAINT IF EXISTS "PayFoodPartnerOrder_EventId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayFoodPartnerOrderItem" DROP CONSTRAINT IF EXISTS "PayFoodPartnerOrderItem_ProductId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayFoodPartnerOrderItem" DROP CONSTRAINT IF EXISTS "PayFoodPartnerOrderItem_OrderId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayCollectionCouponLinkProduct" DROP CONSTRAINT IF EXISTS "PayCollectionCouponLinkProduct_ProductId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayCollectionCouponLinkProduct" DROP CONSTRAINT IF EXISTS "PayCollectionCouponLinkProduct_CouponId_fkey";
ALTER TABLE IF EXISTS ONLY public."PartnerExport" DROP CONSTRAINT IF EXISTS "PartnerExport_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."PartnerExport" DROP CONSTRAINT IF EXISTS "PartnerExport_EventId_fkey";
ALTER TABLE IF EXISTS ONLY public."PayCouponActivationLinkOrderItem" DROP CONSTRAINT IF EXISTS "Key_ActivationLinkOrderItem";
ALTER TABLE IF EXISTS ONLY public."IriUser" DROP CONSTRAINT IF EXISTS "IriUser_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."IriUser" DROP CONSTRAINT IF EXISTS "IriUser_RoleId_fkey";
ALTER TABLE IF EXISTS ONLY public."IriUser" DROP CONSTRAINT IF EXISTS "IriUser_ProfessionalInterestId_fkey";
ALTER TABLE IF EXISTS ONLY public."IctUser" DROP CONSTRAINT IF EXISTS "IctUser_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."IctUser" DROP CONSTRAINT IF EXISTS "IctUser_RoleId_fkey";
ALTER TABLE IF EXISTS ONLY public."IctUser" DROP CONSTRAINT IF EXISTS "IctUser_ProfessionalInterestId_fkey";
ALTER TABLE IF EXISTS ONLY public."GeoRegion" DROP CONSTRAINT IF EXISTS "Geo2Region_CountryId_fkey";
ALTER TABLE IF EXISTS ONLY public."GeoCity" DROP CONSTRAINT IF EXISTS "Geo2City_RegionId_fkey";
ALTER TABLE IF EXISTS ONLY public."GeoCity" DROP CONSTRAINT IF EXISTS "Geo2City_CountryId_fkey";
ALTER TABLE IF EXISTS ONLY public."EventParticipant" DROP CONSTRAINT IF EXISTS "EventParticipant_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."UserEmployment" DROP CONSTRAINT IF EXISTS "Employment_Company_foreign";
ALTER TABLE IF EXISTS ONLY public."EducationUniversity" DROP CONSTRAINT IF EXISTS "EducationUniversity_CityId_fkey";
ALTER TABLE IF EXISTS ONLY public."EducationFaculty" DROP CONSTRAINT IF EXISTS "EducationFaculty_UniversityId_fkey";
ALTER TABLE IF EXISTS ONLY public."ContactAddress" DROP CONSTRAINT IF EXISTS "ContactAddress_RegionId_fkey";
ALTER TABLE IF EXISTS ONLY public."ContactAddress" DROP CONSTRAINT IF EXISTS "ContactAddress_CountryId_fkey";
ALTER TABLE IF EXISTS ONLY public."ContactAddress" DROP CONSTRAINT IF EXISTS "ContactAddress_CityId_fkey";
ALTER TABLE IF EXISTS ONLY public."ConnectMeetingLinkUser" DROP CONSTRAINT IF EXISTS "ConnectMeetingLinkUser_UserId_fkey";
ALTER TABLE IF EXISTS ONLY public."ConnectMeetingLinkUser" DROP CONSTRAINT IF EXISTS "ConnectMeetingLinkUser_MeetingId_fkey";
ALTER TABLE IF EXISTS ONLY public."CompetenceTest" DROP CONSTRAINT IF EXISTS "CompetenceTest_RoleIdAfterPass_fkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkProfessionalInterest" DROP CONSTRAINT IF EXISTS "CompanyLinkProfessionalInterest_ProfessionalInterestId_fkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkProfessionalInterest" DROP CONSTRAINT IF EXISTS "CompanyLinkProfessionalInterest_CompanyId_fkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkCommission" DROP CONSTRAINT IF EXISTS "CompanyLinkCommission_CompanyId_fkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkCommission" DROP CONSTRAINT IF EXISTS "CompanyLinkCommission_CommissionId_fkey";
ALTER TABLE IF EXISTS ONLY public."AttributeDefinition" DROP CONSTRAINT IF EXISTS "AttributeDefinition_GroupId_fkey";
DROP TRIGGER IF EXISTS "UpdateUser" ON public."EventUserData";
DROP TRIGGER IF EXISTS "UpdateUser" ON public."PayOrderItem";
DROP TRIGGER IF EXISTS "UpdateUser" ON public."EventParticipant";
DROP TRIGGER IF EXISTS "UpdateUser" ON public."UserEmployment";
DROP TRIGGER IF EXISTS "IncrementGeoCityPriority" ON public."EducationUniversity";
DROP TRIGGER IF EXISTS "IncrementGeoCityPriority" ON public."ContactAddress";
DROP TRIGGER IF EXISTS "CreateUserSettingsTrigger" ON public."User";
DROP TRIGGER IF EXISTS "CheckPrimaryBefore" ON public."UserEmployment";
DROP TRIGGER IF EXISTS "CheckPrimary" ON public."UserEmployment";
DROP TRIGGER IF EXISTS "CheckActual" ON public."UserDocument";
DROP TRIGGER IF EXISTS "BeforeUpdate" ON public."User";
DROP INDEX IF EXISTS public.idx_pl_ns;
DROP INDEX IF EXISTS public."fki_PayProductPrice_ProductId_fkey";
DROP INDEX IF EXISTS public."fki_PayOrderLinkOrderItem_OrderItemId_fkey";
DROP INDEX IF EXISTS public."fki_PayOrderLinkOrderItem_OrderId_fkey";
DROP INDEX IF EXISTS public."fki_CompetenceTest_RoleIdAfterPass_fkey";
DROP INDEX IF EXISTS public."YiiSession_expire_idx";
DROP INDEX IF EXISTS public."User_UserId_key";
DROP INDEX IF EXISTS public."User_UpdateTime_index";
DROP INDEX IF EXISTS public."User_SearchLastName_idx";
DROP INDEX IF EXISTS public."User_SearchFirstName_idx";
DROP INDEX IF EXISTS public."User_RunetId_key";
DROP INDEX IF EXISTS public."User_LastName_trgm";
DROP INDEX IF EXISTS public."User_LastName_idx";
DROP INDEX IF EXISTS public."User_FullName_key";
DROP INDEX IF EXISTS public."User_FirstName_trgm";
DROP INDEX IF EXISTS public."User_FirstName_idx";
DROP INDEX IF EXISTS public."User_FatherName_trgm";
DROP INDEX IF EXISTS public."User_Email_idx";
DROP INDEX IF EXISTS public."UserSettings_UserId_key";
DROP INDEX IF EXISTS public."UserLinkSite_UserId_index";
DROP INDEX IF EXISTS public."UserLinkServiceAccount_UserId_index";
DROP INDEX IF EXISTS public."UserLinkPhone_UserId_index";
DROP INDEX IF EXISTS public."UserLinkPhone_PhoneId_index";
DROP INDEX IF EXISTS public."UserLinkAddress_UserId_index";
DROP INDEX IF EXISTS public."UserEducation_UserId_idx";
DROP INDEX IF EXISTS public."UserDevice_Token";
DROP INDEX IF EXISTS public."UrlHash";
DROP INDEX IF EXISTS public."Translation_idx";
DROP INDEX IF EXISTS public."TranslationSearchIndex";
DROP INDEX IF EXISTS public."RuventsVisit_MarkId_idx";
DROP INDEX IF EXISTS public."RuventsBadge_EventId_UserId_index";
DROP INDEX IF EXISTS public."PayOrderItem_Refund_index";
DROP INDEX IF EXISTS public."PayOrderItem_ProductId_index";
DROP INDEX IF EXISTS public."PayOrderItem_Paid_index";
DROP INDEX IF EXISTS public."PayOrderItem_OwnerId_index";
DROP INDEX IF EXISTS public."PayOrderItem_Deleted_index";
DROP INDEX IF EXISTS public."PayOrderItem_ChangedOwnerId_index";
DROP INDEX IF EXISTS public."PayCoupon_EventId_Code_key";
DROP INDEX IF EXISTS public."PaperlessDeviceSignal_Processed_idx";
DROP INDEX IF EXISTS public."PaperlessDeviceSignal_EventId_DeviceId_idx";
DROP INDEX IF EXISTS public."MailLog_Hash_idx";
DROP INDEX IF EXISTS public."Job_Url_index";
DROP INDEX IF EXISTS public."IriUser_UserId_ExitTime_index";
DROP INDEX IF EXISTS public."Index_Participant_EventId";
DROP INDEX IF EXISTS public."IKey_CouponLinkOrderItem";
DROP INDEX IF EXISTS public."Hash_btree";
DROP INDEX IF EXISTS public."Hash";
DROP INDEX IF EXISTS public."GeoRegion_SearchName_idx";
DROP INDEX IF EXISTS public."Geo2Region_CountryId_idx";
DROP INDEX IF EXISTS public."Geo2City_SearchName_idx";
DROP INDEX IF EXISTS public."Geo2City_RegionId_idx";
DROP INDEX IF EXISTS public."Geo2City_Name_idx";
DROP INDEX IF EXISTS public."Geo2City_CountryId_idx";
DROP INDEX IF EXISTS public."Event_EventId_key";
DROP INDEX IF EXISTS public."EventUserData_UserId_index";
DROP INDEX IF EXISTS public."EventUserData_EventId_UserId_Deleted_index";
DROP INDEX IF EXISTS public."EventSection_EventId_Deleted_index";
DROP INDEX IF EXISTS public."EventSectionFavorite_UserId_Deleted_index";
DROP INDEX IF EXISTS public."EventParticipant_UserId_index";
DROP INDEX IF EXISTS public."EventParticipant_RoleId_index";
DROP INDEX IF EXISTS public."EventParticipant_PartId_index";
DROP INDEX IF EXISTS public."Employment_UserId_key";
DROP INDEX IF EXISTS public."Employment_CompanyId_key";
DROP INDEX IF EXISTS public."EducationUniversity_CityId_idx";
DROP INDEX IF EXISTS public."EducationFaculty_UniversityId_idx";
DROP INDEX IF EXISTS public."Company_Name_trgm";
DROP INDEX IF EXISTS public."Company_Name_idx";
DROP INDEX IF EXISTS public."Company_Id_key";
DROP INDEX IF EXISTS public."Company_FullName_idx";
DROP INDEX IF EXISTS public."Company_Cluster_idx";
DROP INDEX IF EXISTS public."CompanyLinkModerator_UserId_CompanyId_idx";
DROP INDEX IF EXISTS public."AttributeGroup_ModelName_ModelId_index";
DROP INDEX IF EXISTS public."AttributeGroup_Id_key";
DROP INDEX IF EXISTS public."AttributeDefinition_GroupId_index";
DROP INDEX IF EXISTS public."AttributeDefinition_ClassName_index";
DROP INDEX IF EXISTS public."ApiExternalUser_AccountId_UserId_index";
ALTER TABLE IF EXISTS ONLY public.tbl_migration DROP CONSTRAINT IF EXISTS tbl_migration_pkey;
ALTER TABLE IF EXISTS ONLY public."YiiSession" DROP CONSTRAINT IF EXISTS "YiiSession_pkey";
ALTER TABLE IF EXISTS ONLY public."User" DROP CONSTRAINT IF EXISTS "User_pkey";
ALTER TABLE IF EXISTS ONLY public."UserUnsubscribeEventMail" DROP CONSTRAINT IF EXISTS "UserUnsubscribeEventMail_pkey";
ALTER TABLE IF EXISTS ONLY public."UserSettings" DROP CONSTRAINT IF EXISTS "UserSettings_pkey";
ALTER TABLE IF EXISTS ONLY public."UserReferral" DROP CONSTRAINT IF EXISTS "UserReferral_pkey";
ALTER TABLE IF EXISTS ONLY public."UserLoyaltyProgram" DROP CONSTRAINT IF EXISTS "UserLoyaltyProgram_pkey";
ALTER TABLE IF EXISTS ONLY public."UserLinkSite" DROP CONSTRAINT IF EXISTS "UserLinkSite_pkey";
ALTER TABLE IF EXISTS ONLY public."UserLinkServiceAccount" DROP CONSTRAINT IF EXISTS "UserLinkServiceAccount_pkey";
ALTER TABLE IF EXISTS ONLY public."UserLinkProfessionalInterest" DROP CONSTRAINT IF EXISTS "UserLinkProfessionalInterest_pkey";
ALTER TABLE IF EXISTS ONLY public."UserLinkPhone" DROP CONSTRAINT IF EXISTS "UserLinkPhone_pkey";
ALTER TABLE IF EXISTS ONLY public."UserLinkEmail" DROP CONSTRAINT IF EXISTS "UserLinkEmail_pkey";
ALTER TABLE IF EXISTS ONLY public."UserLinkAddress" DROP CONSTRAINT IF EXISTS "UserLinkAddress_pkey";
ALTER TABLE IF EXISTS ONLY public."UserEmployment" DROP CONSTRAINT IF EXISTS "UserEmployment_pkey";
ALTER TABLE IF EXISTS ONLY public."UserEducation" DROP CONSTRAINT IF EXISTS "UserEducation_pkey";
ALTER TABLE IF EXISTS ONLY public."UserDocument" DROP CONSTRAINT IF EXISTS "UserDocument_pkey";
ALTER TABLE IF EXISTS ONLY public."UserDocumentType" DROP CONSTRAINT IF EXISTS "UserDocumentType_pkey";
ALTER TABLE IF EXISTS ONLY public."UserDevice" DROP CONSTRAINT IF EXISTS "UserDevice_pkey";
ALTER TABLE IF EXISTS ONLY public."Translation" DROP CONSTRAINT IF EXISTS "Translation_pkey";
ALTER TABLE IF EXISTS ONLY public."TmpRifParking" DROP CONSTRAINT IF EXISTS "TmpRifParking_pkey";
ALTER TABLE IF EXISTS ONLY public."Tag" DROP CONSTRAINT IF EXISTS "Tag_pkey";
ALTER TABLE IF EXISTS ONLY public."RuventsVisit" DROP CONSTRAINT IF EXISTS "RuventsVisit_pkey";
ALTER TABLE IF EXISTS ONLY public."RuventsSetting" DROP CONSTRAINT IF EXISTS "RuventsSetting_pkey";
ALTER TABLE IF EXISTS ONLY public."RuventsOperator" DROP CONSTRAINT IF EXISTS "RuventsOperator_pkey";
ALTER TABLE IF EXISTS ONLY public."RuventsDetailLog" DROP CONSTRAINT IF EXISTS "RuventsDetailLog_pkey";
ALTER TABLE IF EXISTS ONLY public."RuventsBadge" DROP CONSTRAINT IF EXISTS "RuventsBadge_pkey";
ALTER TABLE IF EXISTS ONLY public."RuventsAccount" DROP CONSTRAINT IF EXISTS "RuventsAccount_pkey";
ALTER TABLE IF EXISTS ONLY public."RaecCompanyUser" DROP CONSTRAINT IF EXISTS "RaecCompanyUser_pkey";
ALTER TABLE IF EXISTS ONLY public."RaecCompanyUserStatus" DROP CONSTRAINT IF EXISTS "RaecCompanyUserStatus_pkey";
ALTER TABLE IF EXISTS ONLY public."RaecBrief" DROP CONSTRAINT IF EXISTS "RaecBrief_pkey";
ALTER TABLE IF EXISTS ONLY public."RaecBriefUserRole" DROP CONSTRAINT IF EXISTS "RaecBriefUserRole_pkey";
ALTER TABLE IF EXISTS ONLY public."RaecBriefLinkUser" DROP CONSTRAINT IF EXISTS "RaecBriefLinkUser_pkey";
ALTER TABLE IF EXISTS ONLY public."RaecBriefLinkCompany" DROP CONSTRAINT IF EXISTS "RaecBriefCompany_pkey";
ALTER TABLE IF EXISTS ONLY public."ProfessionalInterest" DROP CONSTRAINT IF EXISTS "ProfessionalInterest_pkey";
ALTER TABLE IF EXISTS ONLY public."PayRoomPartnerOrder" DROP CONSTRAINT IF EXISTS "PayRoomPartnerOrder_pkey";
ALTER TABLE IF EXISTS ONLY public."PayRoomPartnerBooking" DROP CONSTRAINT IF EXISTS "PayRoomPartnerBooking_pkey";
ALTER TABLE IF EXISTS ONLY public."PayReferralDiscount" DROP CONSTRAINT IF EXISTS "PayReferralDiscount_pkey";
ALTER TABLE IF EXISTS ONLY public."PayProduct" DROP CONSTRAINT IF EXISTS "PayProduct_pkey";
ALTER TABLE IF EXISTS ONLY public."PayProductUserAccess" DROP CONSTRAINT IF EXISTS "PayProductUserAccess_pkey";
ALTER TABLE IF EXISTS ONLY public."PayProductPrice" DROP CONSTRAINT IF EXISTS "PayProductPrice_pkey";
ALTER TABLE IF EXISTS ONLY public."PayProductCheck" DROP CONSTRAINT IF EXISTS "PayProductGet_pkey";
ALTER TABLE IF EXISTS ONLY public."PayProductAttribute" DROP CONSTRAINT IF EXISTS "PayProductAttribute_pkey";
ALTER TABLE IF EXISTS ONLY public."PayOrder" DROP CONSTRAINT IF EXISTS "PayOrder_pkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderLinkOrderItem" DROP CONSTRAINT IF EXISTS "PayOrderLinkOrderItem_pkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderJuridical" DROP CONSTRAINT IF EXISTS "PayOrderJuridical_pkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderJuridicalTemplate" DROP CONSTRAINT IF EXISTS "PayOrderJuridicalTemplate_pkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderItem" DROP CONSTRAINT IF EXISTS "PayOrderItem_pkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderItemAttribute" DROP CONSTRAINT IF EXISTS "PayOrderItemAttribute_pkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderImport" DROP CONSTRAINT IF EXISTS "PayOrderImport_pkey";
ALTER TABLE IF EXISTS ONLY public."PayOrderImportOrder" DROP CONSTRAINT IF EXISTS "PayOrderImportOrder_pkey1";
ALTER TABLE IF EXISTS ONLY public."PayOrderImportEntry" DROP CONSTRAINT IF EXISTS "PayOrderImportOrder_pkey";
ALTER TABLE IF EXISTS ONLY public."PayLoyaltyProgramDiscount" DROP CONSTRAINT IF EXISTS "PayLoyaltyProgram_pkey";
ALTER TABLE IF EXISTS ONLY public."PayLog" DROP CONSTRAINT IF EXISTS "PayLog_pkey";
ALTER TABLE IF EXISTS ONLY public."PayFoodPartnerOrder" DROP CONSTRAINT IF EXISTS "PayFoodPartnerOrder_pkey";
ALTER TABLE IF EXISTS ONLY public."PayFoodPartnerOrderItem" DROP CONSTRAINT IF EXISTS "PayFoodPartnerOrderItem_pkey";
ALTER TABLE IF EXISTS ONLY public."PayCoupon" DROP CONSTRAINT IF EXISTS "PayCoupon_pkey";
ALTER TABLE IF EXISTS ONLY public."PayCouponLinkProduct" DROP CONSTRAINT IF EXISTS "PayCouponLinkProduct_pkey";
ALTER TABLE IF EXISTS ONLY public."PayCouponActivationLinkOrderItem" DROP CONSTRAINT IF EXISTS "PayCouponActivationLinkOrderItem_pkey";
ALTER TABLE IF EXISTS ONLY public."PayCouponActivation" DROP CONSTRAINT IF EXISTS "PayCouponActivated_pkey";
ALTER TABLE IF EXISTS ONLY public."PayCollectionCoupon" DROP CONSTRAINT IF EXISTS "PayCollectionCoupon_pkey";
ALTER TABLE IF EXISTS ONLY public."PayCollectionCouponLinkProduct" DROP CONSTRAINT IF EXISTS "PayCollectionCouponLinkProduct_pkey";
ALTER TABLE IF EXISTS ONLY public."PayCollectionCouponAttribute" DROP CONSTRAINT IF EXISTS "PayCollectionCouponAttribute_pkey";
ALTER TABLE IF EXISTS ONLY public."PayAccount" DROP CONSTRAINT IF EXISTS "PayAccount_pkey";
ALTER TABLE IF EXISTS ONLY public."PartnerImport" DROP CONSTRAINT IF EXISTS "PartnerImport_pkey";
ALTER TABLE IF EXISTS ONLY public."PartnerImportUser" DROP CONSTRAINT IF EXISTS "PartnerImportUser_pkey";
ALTER TABLE IF EXISTS ONLY public."PartnerExport" DROP CONSTRAINT IF EXISTS "PartnerExport_pkey";
ALTER TABLE IF EXISTS ONLY public."PartnerCallback" DROP CONSTRAINT IF EXISTS "PartnerCallback_pkey";
ALTER TABLE IF EXISTS ONLY public."PartnerCallbackUser" DROP CONSTRAINT IF EXISTS "PartnerCallbackUser_pkey";
ALTER TABLE IF EXISTS ONLY public."PartnerAccount" DROP CONSTRAINT IF EXISTS "PartnerAccount_pkey";
ALTER TABLE IF EXISTS ONLY public."PaperlessMaterial" DROP CONSTRAINT IF EXISTS "PaperlessMaterial_pkey";
ALTER TABLE IF EXISTS ONLY public."PaperlessMaterialLinkUser" DROP CONSTRAINT IF EXISTS "PaperlessMaterialLinkUser_pkey";
ALTER TABLE IF EXISTS ONLY public."PaperlessMaterialLinkRole" DROP CONSTRAINT IF EXISTS "PaperlessMaterialLinkRole_pkey";
ALTER TABLE IF EXISTS ONLY public."PaperlessEvent" DROP CONSTRAINT IF EXISTS "PaperlessEvent_pkey";
ALTER TABLE IF EXISTS ONLY public."PaperlessEventLinkRole" DROP CONSTRAINT IF EXISTS "PaperlessEventLinkRole_pkey";
ALTER TABLE IF EXISTS ONLY public."PaperlessEventLinkMaterial" DROP CONSTRAINT IF EXISTS "PaperlessEventLinkMaterial_pkey";
ALTER TABLE IF EXISTS ONLY public."PaperlessEventLinkDevice" DROP CONSTRAINT IF EXISTS "PaperlessEventLinkDevice_pkey";
ALTER TABLE IF EXISTS ONLY public."PaperlessDevice" DROP CONSTRAINT IF EXISTS "PaperlessDevice_pkey";
ALTER TABLE IF EXISTS ONLY public."PaperlessDeviceSignal" DROP CONSTRAINT IF EXISTS "PaperlessDeviceSignal_pkey";
ALTER TABLE IF EXISTS ONLY public."OAuthSocial" DROP CONSTRAINT IF EXISTS "OAuthSocial_pkey";
ALTER TABLE IF EXISTS ONLY public."OAuthPermission" DROP CONSTRAINT IF EXISTS "OAuthPermission_pkey";
ALTER TABLE IF EXISTS ONLY public."OAuthAccessToken" DROP CONSTRAINT IF EXISTS "OAuthAccessToken_pkey";
ALTER TABLE IF EXISTS ONLY public."News" DROP CONSTRAINT IF EXISTS "News_pkey";
ALTER TABLE IF EXISTS ONLY public."MailTemplate" DROP CONSTRAINT IF EXISTS "MailTemplate_pkey";
ALTER TABLE IF EXISTS ONLY public."MailLog" DROP CONSTRAINT IF EXISTS "MailLog_pkey";
ALTER TABLE IF EXISTS ONLY public."Link" DROP CONSTRAINT IF EXISTS "Link_pkey";
ALTER TABLE IF EXISTS ONLY public."Job" DROP CONSTRAINT IF EXISTS "Jobs_pkey";
ALTER TABLE IF EXISTS ONLY public."JobUp" DROP CONSTRAINT IF EXISTS "JobUp_pkey";
ALTER TABLE IF EXISTS ONLY public."JobPosition" DROP CONSTRAINT IF EXISTS "JobPosition_pkey";
ALTER TABLE IF EXISTS ONLY public."JobCompany" DROP CONSTRAINT IF EXISTS "JobCompany_pkey";
ALTER TABLE IF EXISTS ONLY public."JobCategory" DROP CONSTRAINT IF EXISTS "JobCategory_pkey";
ALTER TABLE IF EXISTS ONLY public."IriUser" DROP CONSTRAINT IF EXISTS "IriUser_pkey";
ALTER TABLE IF EXISTS ONLY public."IriRole" DROP CONSTRAINT IF EXISTS "IriRole_pkey";
ALTER TABLE IF EXISTS ONLY public."IctUser" DROP CONSTRAINT IF EXISTS "IctUser_pkey";
ALTER TABLE IF EXISTS ONLY public."IctRole" DROP CONSTRAINT IF EXISTS "IctRole_pkey";
ALTER TABLE IF EXISTS ONLY public."GeoRegion" DROP CONSTRAINT IF EXISTS "Geo2Region_pkey";
ALTER TABLE IF EXISTS ONLY public."GeoCountry" DROP CONSTRAINT IF EXISTS "Geo2Country_pkey";
ALTER TABLE IF EXISTS ONLY public."GeoCity" DROP CONSTRAINT IF EXISTS "Geo2City_pkey";
ALTER TABLE IF EXISTS ONLY public."Event" DROP CONSTRAINT IF EXISTS "Event_pkey";
ALTER TABLE IF EXISTS ONLY public."EventLinkWidget" DROP CONSTRAINT IF EXISTS "EventWidget_pkey";
ALTER TABLE IF EXISTS ONLY public."EventWidgetClass" DROP CONSTRAINT IF EXISTS "EventWidgetClass_pkey";
ALTER TABLE IF EXISTS ONLY public."EventUserData" DROP CONSTRAINT IF EXISTS "EventUserData_pkey";
ALTER TABLE IF EXISTS ONLY public."EventUserAdditionalAttribute" DROP CONSTRAINT IF EXISTS "EventUserAdditionalAttribute_pkey";
ALTER TABLE IF EXISTS ONLY public."EventType" DROP CONSTRAINT IF EXISTS "EventType_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSection" DROP CONSTRAINT IF EXISTS "EventSection_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionVote" DROP CONSTRAINT IF EXISTS "EventSectionVote_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionUserVisit" DROP CONSTRAINT IF EXISTS "EventSectionUserVisit_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionType" DROP CONSTRAINT IF EXISTS "EventSectionType_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionTheme" DROP CONSTRAINT IF EXISTS "EventSectionTheme_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionRole" DROP CONSTRAINT IF EXISTS "EventSectionRole_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionReport" DROP CONSTRAINT IF EXISTS "EventSectionReport_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionPartner" DROP CONSTRAINT IF EXISTS "EventSectionPartner_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionLinkUser" DROP CONSTRAINT IF EXISTS "EventSectionLinkUser_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionLinkTheme" DROP CONSTRAINT IF EXISTS "EventSectionLinkTheme_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionLinkHall" DROP CONSTRAINT IF EXISTS "EventSectionLinkHall_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionHall" DROP CONSTRAINT IF EXISTS "EventSectionHall_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionFavorite" DROP CONSTRAINT IF EXISTS "EventSectionFavorite_pkey";
ALTER TABLE IF EXISTS ONLY public."EventSectionAttribute" DROP CONSTRAINT IF EXISTS "EventSectionAttribute_pkey";
ALTER TABLE IF EXISTS ONLY public."EventRole" DROP CONSTRAINT IF EXISTS "EventRole_pkey";
ALTER TABLE IF EXISTS ONLY public."EventPurpose" DROP CONSTRAINT IF EXISTS "EventPurpose_pkey";
ALTER TABLE IF EXISTS ONLY public."EventPurposeLink" DROP CONSTRAINT IF EXISTS "EventPurposeLink_pkey";
ALTER TABLE IF EXISTS ONLY public."EventPartner" DROP CONSTRAINT IF EXISTS "EventPartner_pkey";
ALTER TABLE IF EXISTS ONLY public."EventPartnerType" DROP CONSTRAINT IF EXISTS "EventPartnerType_pkey";
ALTER TABLE IF EXISTS ONLY public."EventParticipant" DROP CONSTRAINT IF EXISTS "EventParticipant_pkey";
ALTER TABLE IF EXISTS ONLY public."EventParticipantLog" DROP CONSTRAINT IF EXISTS "EventParticipantLog_pkey";
ALTER TABLE IF EXISTS ONLY public."EventPart" DROP CONSTRAINT IF EXISTS "EventPart_pkey";
ALTER TABLE IF EXISTS ONLY public."EventMeetingPlace" DROP CONSTRAINT IF EXISTS "EventMeetingPlace_pkey";
ALTER TABLE IF EXISTS ONLY public."EventLinkTag" DROP CONSTRAINT IF EXISTS "EventLinkTag_pkey";
ALTER TABLE IF EXISTS ONLY public."EventLinkSite" DROP CONSTRAINT IF EXISTS "EventLinkSite_pkey";
ALTER TABLE IF EXISTS ONLY public."EventLinkRole" DROP CONSTRAINT IF EXISTS "EventLinkRole_pkey";
ALTER TABLE IF EXISTS ONLY public."EventLinkPurpose" DROP CONSTRAINT IF EXISTS "EventLinkPurpose_pkey";
ALTER TABLE IF EXISTS ONLY public."EventLinkProfessionalInterest" DROP CONSTRAINT IF EXISTS "EventLinkProfessionalInterest_pkey";
ALTER TABLE IF EXISTS ONLY public."EventLinkPhone" DROP CONSTRAINT IF EXISTS "EventLinkPhone_pkey";
ALTER TABLE IF EXISTS ONLY public."EventLinkEmail" DROP CONSTRAINT IF EXISTS "EventLinkEmail_pkey";
ALTER TABLE IF EXISTS ONLY public."EventLinkAddress" DROP CONSTRAINT IF EXISTS "EventLinkAddress_pkey";
ALTER TABLE IF EXISTS ONLY public."EventInvite" DROP CONSTRAINT IF EXISTS "EventInvite_pkey";
ALTER TABLE IF EXISTS ONLY public."EventInviteRequest" DROP CONSTRAINT IF EXISTS "EventInviteRequest_pkey";
ALTER TABLE IF EXISTS ONLY public."EventAttribute" DROP CONSTRAINT IF EXISTS "EventAttribute_pkey";
ALTER TABLE IF EXISTS ONLY public."EducationUniversity" DROP CONSTRAINT IF EXISTS "EducationUniversity_pkey";
ALTER TABLE IF EXISTS ONLY public."EducationFaculty" DROP CONSTRAINT IF EXISTS "EducationFaculty_pkey";
ALTER TABLE IF EXISTS ONLY public."ContactSite" DROP CONSTRAINT IF EXISTS "ContactSite_pkey";
ALTER TABLE IF EXISTS ONLY public."ContactServiceType" DROP CONSTRAINT IF EXISTS "ContactServiceType_pkey";
ALTER TABLE IF EXISTS ONLY public."ContactServiceAccount" DROP CONSTRAINT IF EXISTS "ContactServiceAccount_pkey";
ALTER TABLE IF EXISTS ONLY public."ContactPhone" DROP CONSTRAINT IF EXISTS "ContactPhone_pkey";
ALTER TABLE IF EXISTS ONLY public."ContactEmail" DROP CONSTRAINT IF EXISTS "ContactEmail_pkey";
ALTER TABLE IF EXISTS ONLY public."ContactAddress" DROP CONSTRAINT IF EXISTS "ContactAddress_pkey";
ALTER TABLE IF EXISTS ONLY public."ConnectMeeting" DROP CONSTRAINT IF EXISTS "ConnectMeeting_pkey";
ALTER TABLE IF EXISTS ONLY public."ConnectMeetingLinkUser" DROP CONSTRAINT IF EXISTS "ConnectMeetingLinkUser_pkey";
ALTER TABLE IF EXISTS ONLY public."CompetenceTest" DROP CONSTRAINT IF EXISTS "CompetenceTest_pkey";
ALTER TABLE IF EXISTS ONLY public."CompetenceResult" DROP CONSTRAINT IF EXISTS "CompetenceResult_pkey";
ALTER TABLE IF EXISTS ONLY public."CompetenceQuestion" DROP CONSTRAINT IF EXISTS "CompetenceQuestion_pkey";
ALTER TABLE IF EXISTS ONLY public."CompetenceQuestionType" DROP CONSTRAINT IF EXISTS "CompetenceQuestionType_pkey";
ALTER TABLE IF EXISTS ONLY public."Company" DROP CONSTRAINT IF EXISTS "Company_pkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkSite" DROP CONSTRAINT IF EXISTS "CompanyLinkSite_pkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkProfessionalInterest" DROP CONSTRAINT IF EXISTS "CompanyLinkProfessionalInterest_pkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkPhone" DROP CONSTRAINT IF EXISTS "CompanyLinkPhone_pkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkModerator" DROP CONSTRAINT IF EXISTS "CompanyLinkModerator_pkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkEmail" DROP CONSTRAINT IF EXISTS "CompanyLinkEmail_pkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkCommission" DROP CONSTRAINT IF EXISTS "CompanyLinkCommission_pkey";
ALTER TABLE IF EXISTS ONLY public."CompanyLinkAddress" DROP CONSTRAINT IF EXISTS "CompanyLinkAddress_pkey";
ALTER TABLE IF EXISTS ONLY public."Commission" DROP CONSTRAINT IF EXISTS "Commission_pkey";
ALTER TABLE IF EXISTS ONLY public."CommissionUser" DROP CONSTRAINT IF EXISTS "CommissionUser_pkey";
ALTER TABLE IF EXISTS ONLY public."CommissionRole" DROP CONSTRAINT IF EXISTS "CommissionRole_pkey";
ALTER TABLE IF EXISTS ONLY public."CommissionProject" DROP CONSTRAINT IF EXISTS "CommissionProject_pkey";
ALTER TABLE IF EXISTS ONLY public."CommissionProjectUser" DROP CONSTRAINT IF EXISTS "CommissionProjectUser_pkey";
ALTER TABLE IF EXISTS ONLY public."CatalogCompany" DROP CONSTRAINT IF EXISTS "CatalogCompany_pkey";
ALTER TABLE IF EXISTS ONLY public."BuduGuruCourse" DROP CONSTRAINT IF EXISTS "BuduGuruCourse_pkey";
ALTER TABLE IF EXISTS ONLY public."AttributeGroup" DROP CONSTRAINT IF EXISTS "AttributeGroup_pkey";
ALTER TABLE IF EXISTS ONLY public."AttributeDefinition" DROP CONSTRAINT IF EXISTS "AttributeDefinition_pkey";
ALTER TABLE IF EXISTS ONLY public."ApiIP" DROP CONSTRAINT IF EXISTS "ApiIP_pkey";
ALTER TABLE IF EXISTS ONLY public."ApiExternalUser" DROP CONSTRAINT IF EXISTS "ApiExternalUser_pkey";
ALTER TABLE IF EXISTS ONLY public."ApiDomain" DROP CONSTRAINT IF EXISTS "ApiDomain_pkey";
ALTER TABLE IF EXISTS ONLY public."ApiCallbackLog" DROP CONSTRAINT IF EXISTS "ApiCallbackLog_pkey";
ALTER TABLE IF EXISTS ONLY public."ApiAccount" DROP CONSTRAINT IF EXISTS "ApiAccount_pkey";
ALTER TABLE IF EXISTS ONLY public."ApiAccountQuotaByUserLog" DROP CONSTRAINT IF EXISTS "ApiAccountQuotaByUserLog_pkey";
ALTER TABLE IF EXISTS ONLY public."AdminGroup" DROP CONSTRAINT IF EXISTS "AdminGroup_pkey";
ALTER TABLE IF EXISTS ONLY public."AdminGroupUser" DROP CONSTRAINT IF EXISTS "AdminGroupUser_pkey";
ALTER TABLE IF EXISTS ONLY public."AdminGroupRole" DROP CONSTRAINT IF EXISTS "AdminGroupRole_pkey";
ALTER TABLE IF EXISTS public."UserUnsubscribeEventMail" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserSettings" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserReferral" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserLoyaltyProgram" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserLinkSite" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserLinkServiceAccount" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserLinkProfessionalInterest" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserLinkPhone" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserLinkEmail" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserLinkAddress" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserEmployment" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserEducation" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserDocumentType" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserDocument" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."UserDevice" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."User" ALTER COLUMN "RunetId" DROP DEFAULT;
ALTER TABLE IF EXISTS public."User" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."Translation" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."TmpRifParking" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."Tag" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ShortUrl" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RuventsVisit" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RuventsSetting" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RuventsOperator" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RuventsDetailLog" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RuventsBadge" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RuventsAccount" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RaecCompanyUserStatus" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RaecCompanyUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RaecBriefUserRole" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RaecBriefLinkUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RaecBriefLinkCompany" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."RaecBrief" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ProfessionalInterest" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayRoomPartnerOrder" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayRoomPartnerBooking" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayReferralDiscount" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayProductUserAccess" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayProductPrice" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayProductCheck" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayProductAttribute" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayProduct" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayOrderLinkOrderItem" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayOrderJuridicalTemplate" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayOrderJuridical" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayOrderItemAttribute" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayOrderItem" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayOrderImportOrder" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayOrderImportEntry" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayOrderImport" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayOrder" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayLoyaltyProgramDiscount" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayLog" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayFoodPartnerOrderItem" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayFoodPartnerOrder" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayCouponActivationLinkOrderItem" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayCouponActivation" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayCoupon" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayCollectionCouponAttribute" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayCollectionCoupon" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PayAccount" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PartnerImportUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PartnerImport" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PartnerExport" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PartnerCallbackUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PartnerCallback" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PartnerAccount" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessMaterialLinkUser" ALTER COLUMN "UserId" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessMaterialLinkUser" ALTER COLUMN "MaterialId" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessMaterialLinkUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessMaterialLinkRole" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessMaterial" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessEventLinkRole" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessEventLinkMaterial" ALTER COLUMN "MaterialId" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessEventLinkMaterial" ALTER COLUMN "EventId" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessEventLinkMaterial" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessEventLinkDevice" ALTER COLUMN "DeviceId" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessEventLinkDevice" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessEvent" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessDeviceSignal" ALTER COLUMN "BadgeUID" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessDeviceSignal" ALTER COLUMN "DeviceNumber" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessDeviceSignal" ALTER COLUMN "EventId" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessDeviceSignal" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessDevice" ALTER COLUMN "DeviceNumber" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessDevice" ALTER COLUMN "EventId" DROP DEFAULT;
ALTER TABLE IF EXISTS public."PaperlessDevice" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."OAuthSocial" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."OAuthPermission" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."OAuthAccessToken" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."News" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."MailTemplate" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."MailLog" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."Link" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."JobUp" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."JobPosition" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."JobCompany" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."JobCategory" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."Job" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."IriUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."IriRole" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."IctUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."IctRole" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."GeoRegion" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."GeoCountry" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."GeoCity" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventWidgetClass" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventUserData" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventUserAdditionalAttribute" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventType" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionVote" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionUserVisit" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionType" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionTheme" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionRole" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionReport" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionPartner" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionLinkUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionLinkTheme" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionLinkHall" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionHall" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionFavorite" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSectionAttribute" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventSection" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventRole" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventPurposeLink" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventPurpose" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventPartnerType" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventPartner" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventParticipantLog" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventParticipant" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventPart" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventMeetingPlace" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventLinkWidget" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventLinkTag" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventLinkSite" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventLinkRole" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventLinkPurpose" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventLinkProfessionalInterest" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventLinkPhone" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventLinkEmail" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventLinkAddress" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventInviteRequest" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventInvite" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EventAttribute" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."Event" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EducationUniversity" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."EducationFaculty" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ContactSite" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ContactServiceType" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ContactServiceAccount" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ContactPhone" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ContactEmail" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ContactAddress" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ConnectMeetingLinkUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ConnectMeeting" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CompetenceTest" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CompetenceResult" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CompetenceQuestionType" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CompanyLinkSite" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CompanyLinkPhone" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CompanyLinkModerator" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CompanyLinkEmail" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CompanyLinkAddress" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."Company" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CommissionUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CommissionRole" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CommissionProjectUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CommissionProject" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."Commission" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."CatalogCompany" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."AttributeGroup" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."AttributeDefinition" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ApiIP" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ApiExternalUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ApiDomain" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ApiCallbackLog" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."ApiAccount" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."AdminGroupUser" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."AdminGroupRole" ALTER COLUMN "Id" DROP DEFAULT;
ALTER TABLE IF EXISTS public."AdminGroup" ALTER COLUMN "Id" DROP DEFAULT;
DROP TABLE IF EXISTS public.tbl_migration;
DROP SEQUENCE IF EXISTS public.hibernate_sequence;
DROP TABLE IF EXISTS public."YiiSession";
DROP SEQUENCE IF EXISTS public."User_UserId_seq";
DROP SEQUENCE IF EXISTS public."User_RunetId_seq";
DROP SEQUENCE IF EXISTS public."UserUnsubscribeEventMail_Id_seq";
DROP TABLE IF EXISTS public."UserUnsubscribeEventMail";
DROP SEQUENCE IF EXISTS public."UserSettings_Id_seq";
DROP TABLE IF EXISTS public."UserSettings";
DROP SEQUENCE IF EXISTS public."UserReferral_Id_seq";
DROP TABLE IF EXISTS public."UserReferral";
DROP SEQUENCE IF EXISTS public."UserLoyaltyProgram_Id_seq";
DROP TABLE IF EXISTS public."UserLoyaltyProgram";
DROP SEQUENCE IF EXISTS public."UserLinkSite_Id_seq";
DROP TABLE IF EXISTS public."UserLinkSite";
DROP SEQUENCE IF EXISTS public."UserLinkServiceAccount_Id_seq";
DROP TABLE IF EXISTS public."UserLinkServiceAccount";
DROP SEQUENCE IF EXISTS public."UserLinkProfessionalInterest_Id_seq";
DROP TABLE IF EXISTS public."UserLinkProfessionalInterest";
DROP SEQUENCE IF EXISTS public."UserLinkPhone_Id_seq";
DROP TABLE IF EXISTS public."UserLinkPhone";
DROP SEQUENCE IF EXISTS public."UserLinkEmail_Id_seq";
DROP TABLE IF EXISTS public."UserLinkEmail";
DROP SEQUENCE IF EXISTS public."UserLinkAddress_Id_seq";
DROP TABLE IF EXISTS public."UserLinkAddress";
DROP SEQUENCE IF EXISTS public."UserEmployment_Id_seq";
DROP TABLE IF EXISTS public."UserEmployment";
DROP SEQUENCE IF EXISTS public."UserEducation_Id_seq";
DROP TABLE IF EXISTS public."UserEducation";
DROP SEQUENCE IF EXISTS public."UserDocument_Id_seq";
DROP SEQUENCE IF EXISTS public."UserDocumentType_Id_seq";
DROP TABLE IF EXISTS public."UserDocumentType";
DROP TABLE IF EXISTS public."UserDocument";
DROP SEQUENCE IF EXISTS public."UserDevice_Id_seq";
DROP TABLE IF EXISTS public."UserDevice";
DROP TABLE IF EXISTS public."User";
DROP SEQUENCE IF EXISTS public."Translation_Id_seq";
DROP TABLE IF EXISTS public."Translation";
DROP SEQUENCE IF EXISTS public."TmpRifParking_Id_seq";
DROP TABLE IF EXISTS public."TmpRifParking";
DROP SEQUENCE IF EXISTS public."Tag_Id_seq";
DROP TABLE IF EXISTS public."Tag";
DROP SEQUENCE IF EXISTS public."ShortUrl_Id_seq1";
DROP TABLE IF EXISTS public."ShortUrl";
DROP SEQUENCE IF EXISTS public."RuventsVisit_Id_seq";
DROP TABLE IF EXISTS public."RuventsVisit";
DROP SEQUENCE IF EXISTS public."RuventsSetting_Id_seq";
DROP TABLE IF EXISTS public."RuventsSetting";
DROP SEQUENCE IF EXISTS public."RuventsOperator_Id_seq";
DROP TABLE IF EXISTS public."RuventsOperator";
DROP SEQUENCE IF EXISTS public."RuventsDetailLog_Id_seq";
DROP TABLE IF EXISTS public."RuventsDetailLog";
DROP SEQUENCE IF EXISTS public."RuventsBadge_Id_seq";
DROP TABLE IF EXISTS public."RuventsBadge";
DROP SEQUENCE IF EXISTS public."RuventsAccount_Id_seq";
DROP TABLE IF EXISTS public."RuventsAccount";
DROP SEQUENCE IF EXISTS public."RaecCompanyUser_Id_seq";
DROP SEQUENCE IF EXISTS public."RaecCompanyUserStatus_Id_seq";
DROP TABLE IF EXISTS public."RaecCompanyUserStatus";
DROP TABLE IF EXISTS public."RaecCompanyUser";
DROP SEQUENCE IF EXISTS public."RaecBrief_Id_seq";
DROP SEQUENCE IF EXISTS public."RaecBriefUserRole_Id_seq";
DROP TABLE IF EXISTS public."RaecBriefUserRole";
DROP SEQUENCE IF EXISTS public."RaecBriefLinkUser_Id_seq";
DROP TABLE IF EXISTS public."RaecBriefLinkUser";
DROP SEQUENCE IF EXISTS public."RaecBriefCompany_Id_seq";
DROP TABLE IF EXISTS public."RaecBriefLinkCompany";
DROP TABLE IF EXISTS public."RaecBrief";
DROP SEQUENCE IF EXISTS public."ProfessionalInterest_Id_seq";
DROP TABLE IF EXISTS public."ProfessionalInterest";
DROP SEQUENCE IF EXISTS public."PayRoomPartnerOrder_Id_seq";
DROP TABLE IF EXISTS public."PayRoomPartnerOrder";
DROP SEQUENCE IF EXISTS public."PayRoomPartnerBooking_Id_seq";
DROP SEQUENCE IF EXISTS public."PayReferralDiscount_Id_seq";
DROP TABLE IF EXISTS public."PayReferralDiscount";
DROP SEQUENCE IF EXISTS public."PayProduct_Id_seq";
DROP SEQUENCE IF EXISTS public."PayProductUserAccess_Id_seq";
DROP TABLE IF EXISTS public."PayProductUserAccess";
DROP SEQUENCE IF EXISTS public."PayProductPrice_Id_seq";
DROP TABLE IF EXISTS public."PayProductPrice";
DROP SEQUENCE IF EXISTS public."PayProductGet_Id_seq";
DROP TABLE IF EXISTS public."PayProductCheck";
DROP SEQUENCE IF EXISTS public."PayProductAttribute_Id_seq";
DROP TABLE IF EXISTS public."PayProductAttribute";
DROP TABLE IF EXISTS public."PayProduct";
DROP SEQUENCE IF EXISTS public."PayOrder_Id_seq";
DROP SEQUENCE IF EXISTS public."PayOrderLinkOrderItem_Id_seq";
DROP TABLE IF EXISTS public."PayOrderLinkOrderItem";
DROP SEQUENCE IF EXISTS public."PayOrderJuridical_Id_seq";
DROP SEQUENCE IF EXISTS public."PayOrderJuridicalTemplate_Id_seq";
DROP TABLE IF EXISTS public."PayOrderJuridicalTemplate";
DROP TABLE IF EXISTS public."PayOrderJuridical";
DROP SEQUENCE IF EXISTS public."PayOrderItem_Id_seq";
DROP SEQUENCE IF EXISTS public."PayOrderItemAttribute_Id_seq";
DROP TABLE IF EXISTS public."PayOrderItemAttribute";
DROP TABLE IF EXISTS public."PayOrderItem";
DROP SEQUENCE IF EXISTS public."PayOrderImport_Id_seq";
DROP SEQUENCE IF EXISTS public."PayOrderImportOrder_Id_seq1";
DROP SEQUENCE IF EXISTS public."PayOrderImportOrder_Id_seq";
DROP TABLE IF EXISTS public."PayOrderImportOrder";
DROP TABLE IF EXISTS public."PayOrderImportEntry";
DROP TABLE IF EXISTS public."PayOrderImport";
DROP TABLE IF EXISTS public."PayOrder";
DROP SEQUENCE IF EXISTS public."PayLog_Id_seq";
DROP TABLE IF EXISTS public."PayLog";
DROP SEQUENCE IF EXISTS public."PayLoayaltyProgram_Id_seq";
DROP TABLE IF EXISTS public."PayLoyaltyProgramDiscount";
DROP SEQUENCE IF EXISTS public."PayFoodPartnerOrder_Id_seq";
DROP SEQUENCE IF EXISTS public."PayFoodPartnerOrderItem_Id_seq";
DROP TABLE IF EXISTS public."PayFoodPartnerOrderItem";
DROP TABLE IF EXISTS public."PayFoodPartnerOrder";
DROP SEQUENCE IF EXISTS public."PayCoupon_Id_seq";
DROP TABLE IF EXISTS public."PayCouponLinkProduct";
DROP SEQUENCE IF EXISTS public."PayCouponActivationLinkOrderItem_Id_seq";
DROP TABLE IF EXISTS public."PayCouponActivationLinkOrderItem";
DROP SEQUENCE IF EXISTS public."PayCouponActivated_Id_seq";
DROP TABLE IF EXISTS public."PayCouponActivation";
DROP TABLE IF EXISTS public."PayCoupon";
DROP SEQUENCE IF EXISTS public."PayCollectionCoupon_Id_seq";
DROP TABLE IF EXISTS public."PayCollectionCouponLinkProduct";
DROP SEQUENCE IF EXISTS public."PayCollectionCouponAttribute_Id_seq";
DROP TABLE IF EXISTS public."PayCollectionCouponAttribute";
DROP TABLE IF EXISTS public."PayCollectionCoupon";
DROP SEQUENCE IF EXISTS public."PayAccount_Id_seq";
DROP TABLE IF EXISTS public."PayAccount";
DROP SEQUENCE IF EXISTS public."PartnerImport_Id_seq";
DROP SEQUENCE IF EXISTS public."PartnerImportUser_Id_seq";
DROP TABLE IF EXISTS public."PartnerImportUser";
DROP TABLE IF EXISTS public."PartnerImport";
DROP SEQUENCE IF EXISTS public."PartnerExport_Id_seq";
DROP TABLE IF EXISTS public."PartnerExport";
DROP SEQUENCE IF EXISTS public."PartnerCallback_Id_seq";
DROP SEQUENCE IF EXISTS public."PartnerCallbackUser_Id_seq";
DROP TABLE IF EXISTS public."PartnerCallbackUser";
DROP TABLE IF EXISTS public."PartnerCallback";
DROP SEQUENCE IF EXISTS public."PartnerAccount_Id_seq";
DROP TABLE IF EXISTS public."PartnerAccount";
DROP SEQUENCE IF EXISTS public."PaperlessMaterial_Id_seq";
DROP SEQUENCE IF EXISTS public."PaperlessMaterialLinkUser_UserId_seq";
DROP SEQUENCE IF EXISTS public."PaperlessMaterialLinkUser_MaterialId_seq";
DROP SEQUENCE IF EXISTS public."PaperlessMaterialLinkUser_Id_seq";
DROP TABLE IF EXISTS public."PaperlessMaterialLinkUser";
DROP SEQUENCE IF EXISTS public."PaperlessMaterialLinkRole_Id_seq";
DROP TABLE IF EXISTS public."PaperlessMaterialLinkRole";
DROP TABLE IF EXISTS public."PaperlessMaterial";
DROP SEQUENCE IF EXISTS public."PaperlessEvent_Id_seq";
DROP SEQUENCE IF EXISTS public."PaperlessEventLinkRole_Id_seq";
DROP TABLE IF EXISTS public."PaperlessEventLinkRole";
DROP SEQUENCE IF EXISTS public."PaperlessEventLinkMaterial_MaterialId_seq";
DROP SEQUENCE IF EXISTS public."PaperlessEventLinkMaterial_Id_seq";
DROP SEQUENCE IF EXISTS public."PaperlessEventLinkMaterial_EventId_seq";
DROP TABLE IF EXISTS public."PaperlessEventLinkMaterial";
DROP SEQUENCE IF EXISTS public."PaperlessEventLinkDevice_Id_seq";
DROP SEQUENCE IF EXISTS public."PaperlessEventLinkDevice_DeviceId_seq";
DROP TABLE IF EXISTS public."PaperlessEventLinkDevice";
DROP TABLE IF EXISTS public."PaperlessEvent";
DROP SEQUENCE IF EXISTS public."PaperlessDevice_Id_seq";
DROP SEQUENCE IF EXISTS public."PaperlessDevice_EventId_seq";
DROP SEQUENCE IF EXISTS public."PaperlessDevice_DeviceId_seq";
DROP SEQUENCE IF EXISTS public."PaperlessDeviceSignal_Id_seq";
DROP SEQUENCE IF EXISTS public."PaperlessDeviceSignal_EventId_seq";
DROP SEQUENCE IF EXISTS public."PaperlessDeviceSignal_DeviceId_seq";
DROP SEQUENCE IF EXISTS public."PaperlessDeviceSignal_BadgeId_seq";
DROP TABLE IF EXISTS public."PaperlessDeviceSignal";
DROP TABLE IF EXISTS public."PaperlessDevice";
DROP SEQUENCE IF EXISTS public."OAuthSocial_Id_seq";
DROP TABLE IF EXISTS public."OAuthSocial";
DROP SEQUENCE IF EXISTS public."OAuthPermission_Id_seq";
DROP TABLE IF EXISTS public."OAuthPermission";
DROP SEQUENCE IF EXISTS public."OAuthAccessToken_Id_seq";
DROP TABLE IF EXISTS public."OAuthAccessToken";
DROP SEQUENCE IF EXISTS public."News_Id_seq";
DROP TABLE IF EXISTS public."News";
DROP SEQUENCE IF EXISTS public."MailTemplate_Id_seq";
DROP TABLE IF EXISTS public."MailTemplate";
DROP SEQUENCE IF EXISTS public."MailLog_Id_seq";
DROP TABLE IF EXISTS public."MailLog";
DROP SEQUENCE IF EXISTS public."Link_Id_seq";
DROP TABLE IF EXISTS public."Link";
DROP SEQUENCE IF EXISTS public."Jobs_Id_seq";
DROP SEQUENCE IF EXISTS public."JobUp_Id_seq";
DROP TABLE IF EXISTS public."JobUp";
DROP SEQUENCE IF EXISTS public."JobPosition_Id_seq";
DROP TABLE IF EXISTS public."JobPosition";
DROP SEQUENCE IF EXISTS public."JobCompany_Id_seq";
DROP TABLE IF EXISTS public."JobCompany";
DROP SEQUENCE IF EXISTS public."JobCategory_Id_seq";
DROP TABLE IF EXISTS public."JobCategory";
DROP TABLE IF EXISTS public."Job";
DROP SEQUENCE IF EXISTS public."IriUser_Id_seq";
DROP TABLE IF EXISTS public."IriUser";
DROP SEQUENCE IF EXISTS public."IriRole_Id_seq";
DROP TABLE IF EXISTS public."IriRole";
DROP SEQUENCE IF EXISTS public."IctUser_Id_seq";
DROP TABLE IF EXISTS public."IctUser";
DROP SEQUENCE IF EXISTS public."IctRole_Id_seq";
DROP TABLE IF EXISTS public."IctRole";
DROP SEQUENCE IF EXISTS public."Geo2Region_Id_seq";
DROP TABLE IF EXISTS public."GeoRegion";
DROP SEQUENCE IF EXISTS public."Geo2Country_Id_seq";
DROP TABLE IF EXISTS public."GeoCountry";
DROP SEQUENCE IF EXISTS public."Geo2City_Id_seq";
DROP TABLE IF EXISTS public."GeoCity";
DROP SEQUENCE IF EXISTS public."Event_EventId_seq";
DROP SEQUENCE IF EXISTS public."EventWidget_Id_seq";
DROP SEQUENCE IF EXISTS public."EventWidgetClass_Id_seq";
DROP TABLE IF EXISTS public."EventWidgetClass";
DROP SEQUENCE IF EXISTS public."EventUserData_Id_seq";
DROP TABLE IF EXISTS public."EventUserData";
DROP SEQUENCE IF EXISTS public."EventUserAdditionalAttribute_Id_seq";
DROP TABLE IF EXISTS public."EventUserAdditionalAttribute";
DROP SEQUENCE IF EXISTS public."EventType_Id_seq";
DROP TABLE IF EXISTS public."EventType";
DROP SEQUENCE IF EXISTS public."EventSection_Id_seq";
DROP SEQUENCE IF EXISTS public."EventSectionVote_Id_seq";
DROP TABLE IF EXISTS public."EventSectionVote";
DROP SEQUENCE IF EXISTS public."EventSectionUserVisit_Id_seq";
DROP TABLE IF EXISTS public."EventSectionUserVisit";
DROP SEQUENCE IF EXISTS public."EventSectionType_Id_seq";
DROP TABLE IF EXISTS public."EventSectionType";
DROP SEQUENCE IF EXISTS public."EventSectionTheme_Id_seq";
DROP TABLE IF EXISTS public."EventSectionTheme";
DROP SEQUENCE IF EXISTS public."EventSectionRole_Id_seq";
DROP TABLE IF EXISTS public."EventSectionRole";
DROP SEQUENCE IF EXISTS public."EventSectionReport_Id_seq";
DROP TABLE IF EXISTS public."EventSectionReport";
DROP SEQUENCE IF EXISTS public."EventSectionPartner_Id_seq";
DROP TABLE IF EXISTS public."EventSectionPartner";
DROP SEQUENCE IF EXISTS public."EventSectionLinkUser_Id_seq";
DROP TABLE IF EXISTS public."EventSectionLinkUser";
DROP SEQUENCE IF EXISTS public."EventSectionLinkTheme_Id_seq";
DROP TABLE IF EXISTS public."EventSectionLinkTheme";
DROP SEQUENCE IF EXISTS public."EventSectionLinkHall_Id_seq";
DROP TABLE IF EXISTS public."EventSectionLinkHall";
DROP SEQUENCE IF EXISTS public."EventSectionHall_Id_seq";
DROP TABLE IF EXISTS public."EventSectionHall";
DROP SEQUENCE IF EXISTS public."EventSectionFavorite_Id_seq";
DROP TABLE IF EXISTS public."EventSectionFavorite";
DROP SEQUENCE IF EXISTS public."EventSectionAttribute_Id_seq";
DROP TABLE IF EXISTS public."EventSectionAttribute";
DROP TABLE IF EXISTS public."EventSection";
DROP SEQUENCE IF EXISTS public."EventRole_Id_seq";
DROP TABLE IF EXISTS public."EventRole";
DROP SEQUENCE IF EXISTS public."EventPurpose_Id_seq";
DROP SEQUENCE IF EXISTS public."EventPurposeLink_Id_seq";
DROP TABLE IF EXISTS public."EventPurposeLink";
DROP TABLE IF EXISTS public."EventPurpose";
DROP SEQUENCE IF EXISTS public."EventPartner_Id_seq";
DROP SEQUENCE IF EXISTS public."EventPartnerType_Id_seq";
DROP TABLE IF EXISTS public."EventPartnerType";
DROP TABLE IF EXISTS public."EventPartner";
DROP SEQUENCE IF EXISTS public."EventParticipant_Id_seq";
DROP SEQUENCE IF EXISTS public."EventParticipantLog_Id_seq";
DROP TABLE IF EXISTS public."EventParticipantLog";
DROP TABLE IF EXISTS public."EventParticipant";
DROP SEQUENCE IF EXISTS public."EventPart_Id_seq";
DROP TABLE IF EXISTS public."EventPart";
DROP SEQUENCE IF EXISTS public."EventMeetingPlace_Id_seq";
DROP TABLE IF EXISTS public."EventMeetingPlace";
DROP TABLE IF EXISTS public."EventLinkWidget";
DROP SEQUENCE IF EXISTS public."EventLinkTag_Id_seq";
DROP TABLE IF EXISTS public."EventLinkTag";
DROP SEQUENCE IF EXISTS public."EventLinkSite_Id_seq";
DROP TABLE IF EXISTS public."EventLinkSite";
DROP SEQUENCE IF EXISTS public."EventLinkRole_Id_seq";
DROP TABLE IF EXISTS public."EventLinkRole";
DROP SEQUENCE IF EXISTS public."EventLinkPurpose_Id_seq";
DROP TABLE IF EXISTS public."EventLinkPurpose";
DROP SEQUENCE IF EXISTS public."EventLinkProfessionalInterest_Id_seq";
DROP TABLE IF EXISTS public."EventLinkProfessionalInterest";
DROP SEQUENCE IF EXISTS public."EventLinkPhone_Id_seq";
DROP TABLE IF EXISTS public."EventLinkPhone";
DROP SEQUENCE IF EXISTS public."EventLinkEmail_Id_seq";
DROP TABLE IF EXISTS public."EventLinkEmail";
DROP SEQUENCE IF EXISTS public."EventLinkAddress_Id_seq";
DROP TABLE IF EXISTS public."EventLinkAddress";
DROP SEQUENCE IF EXISTS public."EventInvite_Id_seq";
DROP SEQUENCE IF EXISTS public."EventInviteRequest_Id_seq";
DROP TABLE IF EXISTS public."EventInviteRequest";
DROP TABLE IF EXISTS public."EventInvite";
DROP SEQUENCE IF EXISTS public."EventAttribute_Id_seq";
DROP TABLE IF EXISTS public."EventAttribute";
DROP TABLE IF EXISTS public."Event";
DROP SEQUENCE IF EXISTS public."EducationUniversity_Id_seq";
DROP TABLE IF EXISTS public."EducationUniversity";
DROP SEQUENCE IF EXISTS public."EducationFaculty_Id_seq";
DROP TABLE IF EXISTS public."EducationFaculty";
DROP SEQUENCE IF EXISTS public."ContactSite_Id_seq";
DROP TABLE IF EXISTS public."ContactSite";
DROP SEQUENCE IF EXISTS public."ContactServiceType_Id_seq";
DROP TABLE IF EXISTS public."ContactServiceType";
DROP SEQUENCE IF EXISTS public."ContactServiceAccount_Id_seq";
DROP TABLE IF EXISTS public."ContactServiceAccount";
DROP SEQUENCE IF EXISTS public."ContactPhone_Id_seq";
DROP TABLE IF EXISTS public."ContactPhone";
DROP SEQUENCE IF EXISTS public."ContactEmail_Id_seq";
DROP TABLE IF EXISTS public."ContactEmail";
DROP SEQUENCE IF EXISTS public."ContactAddress_Id_seq";
DROP TABLE IF EXISTS public."ContactAddress";
DROP SEQUENCE IF EXISTS public."ConnectMeeting_Id_seq";
DROP SEQUENCE IF EXISTS public."ConnectMeetingLinkUser_Id_seq";
DROP TABLE IF EXISTS public."ConnectMeetingLinkUser";
DROP TABLE IF EXISTS public."ConnectMeeting";
DROP SEQUENCE IF EXISTS public."CompetenceTest_Id_seq";
DROP TABLE IF EXISTS public."CompetenceTest";
DROP SEQUENCE IF EXISTS public."CompetenceResult_Id_seq";
DROP TABLE IF EXISTS public."CompetenceResult";
DROP SEQUENCE IF EXISTS public."CompetenceQuestionType_Id_seq";
DROP TABLE IF EXISTS public."CompetenceQuestionType";
DROP TABLE IF EXISTS public."CompetenceQuestion";
DROP SEQUENCE IF EXISTS public."CompetenceQuestion_Id_seq";
DROP TABLE IF EXISTS public."PayRoomPartnerBooking";
DROP SEQUENCE IF EXISTS public."Company_Id_seq";
DROP SEQUENCE IF EXISTS public."CompanyLinkSite_Id_seq";
DROP TABLE IF EXISTS public."CompanyLinkSite";
DROP TABLE IF EXISTS public."CompanyLinkProfessionalInterest";
DROP SEQUENCE IF EXISTS public."CompanyLinkPhone_Id_seq";
DROP TABLE IF EXISTS public."CompanyLinkPhone";
DROP SEQUENCE IF EXISTS public."CompanyLinkModerator_Id_seq";
DROP TABLE IF EXISTS public."CompanyLinkModerator";
DROP SEQUENCE IF EXISTS public."CompanyLinkEmail_Id_seq";
DROP TABLE IF EXISTS public."CompanyLinkEmail";
DROP TABLE IF EXISTS public."CompanyLinkCommission";
DROP SEQUENCE IF EXISTS public."CompanyLinkAddress_Id_seq";
DROP TABLE IF EXISTS public."CompanyLinkAddress";
DROP TABLE IF EXISTS public."Company";
DROP SEQUENCE IF EXISTS public."Commission_Id_seq";
DROP SEQUENCE IF EXISTS public."CommissionUser_Id_seq";
DROP TABLE IF EXISTS public."CommissionUser";
DROP SEQUENCE IF EXISTS public."CommissionRole_Id_seq";
DROP TABLE IF EXISTS public."CommissionRole";
DROP SEQUENCE IF EXISTS public."CommissionProject_Id_seq";
DROP SEQUENCE IF EXISTS public."CommissionProjectUser_Id_seq";
DROP TABLE IF EXISTS public."CommissionProjectUser";
DROP TABLE IF EXISTS public."CommissionProject";
DROP TABLE IF EXISTS public."Commission";
DROP SEQUENCE IF EXISTS public."CatalogCompany_Id_seq";
DROP TABLE IF EXISTS public."CatalogCompany";
DROP TABLE IF EXISTS public."BuduGuruCourse";
DROP SEQUENCE IF EXISTS public."AttributeGroup_Id_seq";
DROP TABLE IF EXISTS public."AttributeGroup";
DROP SEQUENCE IF EXISTS public."AttributeDefinition_Id_seq";
DROP TABLE IF EXISTS public."AttributeDefinition";
DROP SEQUENCE IF EXISTS public."ApiIP_Id_seq";
DROP TABLE IF EXISTS public."ApiIP";
DROP SEQUENCE IF EXISTS public."ApiExternalUser_Id_seq";
DROP TABLE IF EXISTS public."ApiExternalUser";
DROP SEQUENCE IF EXISTS public."ApiDomain_Id_seq";
DROP TABLE IF EXISTS public."ApiDomain";
DROP SEQUENCE IF EXISTS public."ApiCallbackLog_Id_seq";
DROP TABLE IF EXISTS public."ApiCallbackLog";
DROP SEQUENCE IF EXISTS public."ApiAccount_Id_seq";
DROP TABLE IF EXISTS public."ApiAccountQuotaByUserLog";
DROP TABLE IF EXISTS public."ApiAccount";
DROP SEQUENCE IF EXISTS public."AdminGroup_Id_seq";
DROP SEQUENCE IF EXISTS public."AdminGroupUser_Id_seq";
DROP TABLE IF EXISTS public."AdminGroupUser";
DROP SEQUENCE IF EXISTS public."AdminGroupRole_Id_seq";
DROP TABLE IF EXISTS public."AdminGroupRole";
DROP TABLE IF EXISTS public."AdminGroup";
DROP FUNCTION IF EXISTS public.createusersettings();
DROP FUNCTION IF EXISTS public."UserUpdateTimeByUserId"();
DROP FUNCTION IF EXISTS public."UserUpdateTimeByOwnerId"();
DROP FUNCTION IF EXISTS public."UserUpdate"();
DROP FUNCTION IF EXISTS public."UpdateEmploymentPrimary"(userid integer);
DROP FUNCTION IF EXISTS public."IncrementGeoCityPriority"();
DROP FUNCTION IF EXISTS public."CreateUserSettings2"();
DROP FUNCTION IF EXISTS public."CreateUserSettings"();
DROP FUNCTION IF EXISTS public."CheckUserDocumentActual"();
DROP FUNCTION IF EXISTS public."CheckEmploymentPrimary"();
DROP FUNCTION IF EXISTS public."CheckEmploymentBefore"();
DROP TYPE IF EXISTS public."RoleType";
DROP TYPE IF EXISTS public."RequiredStatus";
DROP TYPE IF EXISTS public."PhoneType";
DROP TYPE IF EXISTS public."PartnerAccountRequestPhoneOnRegisterStatus";
DROP TYPE IF EXISTS public."MailTemplateLayout";
DROP TYPE IF EXISTS public."Gender";
DROP TYPE IF EXISTS public."EducationDegree";
DROP TYPE IF EXISTS public."DeviceType";
DROP TYPE IF EXISTS public."CompanyClusterType";
DROP EXTENSION IF EXISTS pg_trgm;
DROP EXTENSION IF EXISTS plpgsql;
DROP SCHEMA IF EXISTS public;
--
-- Name: public; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA public;


--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: pg_trgm; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pg_trgm WITH SCHEMA public;


--
-- Name: EXTENSION pg_trgm; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION pg_trgm IS 'text similarity measurement and index searching based on trigrams';


SET search_path = public, pg_catalog;

--
-- Name: CompanyClusterType; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE "CompanyClusterType" AS ENUM (
    '',
    'РАЭК'
);


--
-- Name: DeviceType; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE "DeviceType" AS ENUM (
    'iOS',
    'Android'
);


--
-- Name: EducationDegree; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE "EducationDegree" AS ENUM (
    'bachelor',
    'master',
    'specialist',
    'candidate',
    'doctor'
);


--
-- Name: Gender; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE "Gender" AS ENUM (
    'none',
    'male',
    'female'
);


--
-- Name: MailTemplateLayout; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE "MailTemplateLayout" AS ENUM (
    'none',
    'one-column',
    'two-column'
);


--
-- Name: PartnerAccountRequestPhoneOnRegisterStatus; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE "PartnerAccountRequestPhoneOnRegisterStatus" AS ENUM (
    'none',
    'required',
    'not required'
);


--
-- Name: PhoneType; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE "PhoneType" AS ENUM (
    'mobile',
    'work'
);


--
-- Name: RequiredStatus; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE "RequiredStatus" AS ENUM (
    'none',
    'required',
    'not required'
);


--
-- Name: RoleType; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE "RoleType" AS ENUM (
    'none',
    'listener',
    'speaker',
    'master'
);


--
-- Name: CheckEmploymentBefore(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION "CheckEmploymentBefore"() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
  BEGIN
    IF NEW."Primary" AND NEW."EndYear" IS NOT NULL THEN
      NEW."Primary" = FALSE;
    END IF;
    RETURN NEW;
  END
  $$;


--
-- Name: CheckEmploymentPrimary(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION "CheckEmploymentPrimary"() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
IF NEW."Primary" THEN
	UPDATE "public"."UserEmployment"
	SET "Primary" = FALSE
	WHERE "UserId" = NEW."UserId" AND "Id" != NEW."Id";
END IF;
RETURN NEW;
END
$$;


--
-- Name: CheckUserDocumentActual(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION "CheckUserDocumentActual"() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
                BEGIN
                    IF NEW."Actual" THEN
                        UPDATE "public"."UserDocument"
                        SET "Actual" = FALSE
                        WHERE "UserId" = NEW."UserId" AND "TypeId" = NEW."TypeId" AND "Id" != NEW."Id";
                    END IF;
                    RETURN NEW;
                END;
            $$;


--
-- Name: CreateUserSettings(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION "CreateUserSettings"() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
INSERT INTO "UserSettings" (UserId) VALUES (NEW.Id);
END
$$;


--
-- Name: CreateUserSettings2(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION "CreateUserSettings2"() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
INSERT INTO "UserSettings" (UserId) VALUES (NEW.Id);
END
$$;


--
-- Name: IncrementGeoCityPriority(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION "IncrementGeoCityPriority"() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
                BEGIN
                	IF NEW."CityId" IS NOT NULL THEN
                		UPDATE "GeoCity" SET "Priority" = "Priority" + 1 WHERE "Id" = NEW."CityId";
					END IF;
                    RETURN NEW;
                END;
            $$;


--
-- Name: UpdateEmploymentPrimary(integer); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION "UpdateEmploymentPrimary"(userid integer) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
  DECLARE
    result RECORD;
    employment "UserEmployment"%ROWTYPE;
  BEGIN
    SELECT * INTO result FROM "UserEmployment" WHERE "UserId" = userid AND "Primary";
    IF NOT FOUND THEN
      SELECT * INTO employment FROM "UserEmployment" WHERE "UserId" = userid AND "EndYear" IS NULL ORDER BY "StartYear" DESC, "StartMonth" DESC;
      IF FOUND THEN
        UPDATE "UserEmployment"
        SET "Primary" = TRUE
        WHERE "UserEmployment"."Id" = employment."Id";
      END IF;
    END IF;
    RETURN TRUE;
  END
  $$;


--
-- Name: UserUpdate(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION "UserUpdate"() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
  BEGIN
    NEW."UpdateTime" = LOCALTIMESTAMP(0);
    RETURN NEW;
  END
  $$;


--
-- Name: UserUpdateTimeByOwnerId(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION "UserUpdateTimeByOwnerId"() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  IF (TG_OP = 'DELETE') THEN
    UPDATE "public"."User" SET "UpdateTime" = LOCALTIMESTAMP(0) WHERE "Id" = OLD."OwnerId";
    IF OLD."ChangedOwnerId" IS NOT NULL THEN
      UPDATE "public"."User" SET "UpdateTime" = LOCALTIMESTAMP(0) WHERE "Id" = OLD."ChangedOwnerId";
    END IF;
    RETURN OLD;
  ELSE
    UPDATE "public"."User" SET "UpdateTime" = LOCALTIMESTAMP(0) WHERE "Id" = NEW."OwnerId";
    IF NEW."ChangedOwnerId" IS NOT NULL THEN
      UPDATE "public"."User" SET "UpdateTime" = LOCALTIMESTAMP(0) WHERE "Id" = NEW."ChangedOwnerId";
    END IF;
    IF (TG_OP = 'UPDATE' AND NEW."ChangedOwnerId" != OLD."ChangedOwnerId") THEN
      UPDATE "public"."User" SET "UpdateTime" = LOCALTIMESTAMP(0) WHERE "Id" = OLD."ChangedOwnerId";
    END IF;
    RETURN NEW;
  END IF;
END
$$;


--
-- Name: UserUpdateTimeByUserId(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION "UserUpdateTimeByUserId"() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  IF (TG_OP = 'DELETE') THEN
    UPDATE "public"."User" SET "UpdateTime" = LOCALTIMESTAMP(0) WHERE "Id" = OLD."UserId";
    RETURN OLD;
  ELSE
    UPDATE "public"."User" SET "UpdateTime" = LOCALTIMESTAMP(0) WHERE "Id" = NEW."UserId";
    RETURN NEW;
  END IF;
END
$$;


--
-- Name: createusersettings(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION createusersettings() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
INSERT INTO "public"."UserSettings" ("UserId") VALUES (NEW."Id");
RETURN NEW;
END
$$;


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: AdminGroup; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "AdminGroup" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Password" character varying(255)
);


--
-- Name: AdminGroupRole; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "AdminGroupRole" (
    "Id" integer NOT NULL,
    "GroupId" integer NOT NULL,
    "Code" character varying(255) NOT NULL,
    "Title" character varying(255)
);


--
-- Name: AdminGroupRole_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "AdminGroupRole_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: AdminGroupRole_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "AdminGroupRole_Id_seq" OWNED BY "AdminGroupRole"."Id";


--
-- Name: AdminGroupUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "AdminGroupUser" (
    "Id" integer NOT NULL,
    "GroupId" integer NOT NULL,
    "UserId" integer NOT NULL
);


--
-- Name: AdminGroupUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "AdminGroupUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: AdminGroupUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "AdminGroupUser_Id_seq" OWNED BY "AdminGroupUser"."Id";


--
-- Name: AdminGroup_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "AdminGroup_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: AdminGroup_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "AdminGroup_Id_seq" OWNED BY "AdminGroup"."Id";


--
-- Name: ApiAccount; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ApiAccount" (
    "Id" integer NOT NULL,
    "Key" character varying(255) NOT NULL,
    "Secret" character varying(255) NOT NULL,
    "EventId" integer,
    "Role" character varying(255) DEFAULT NULL::character varying,
    "RequestPhoneOnRegistration" "RequiredStatus" DEFAULT 'none'::"RequiredStatus" NOT NULL,
    "QuotaByUser" integer,
    "Blocked" boolean,
    "BlockedReason" text
);


--
-- Name: ApiAccountQuotaByUserLog; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ApiAccountQuotaByUserLog" (
    "AccountId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "Time" timestamp without time zone NOT NULL
);


--
-- Name: ApiAccount_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ApiAccount_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ApiAccount_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ApiAccount_Id_seq" OWNED BY "ApiAccount"."Id";


--
-- Name: ApiCallbackLog; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ApiCallbackLog" (
    "Id" integer NOT NULL,
    "AccountId" integer NOT NULL,
    "Url" character varying(1000) DEFAULT NULL::character varying,
    "Params" text,
    "Response" text,
    "ErrorCode" integer,
    "ErrorMessage" character varying(1000) DEFAULT NULL::character varying,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: ApiCallbackLog_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ApiCallbackLog_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ApiCallbackLog_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ApiCallbackLog_Id_seq" OWNED BY "ApiCallbackLog"."Id";


--
-- Name: ApiDomain; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ApiDomain" (
    "Id" integer NOT NULL,
    "AccountId" integer NOT NULL,
    "Domain" character varying(255) NOT NULL
);


--
-- Name: ApiDomain_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ApiDomain_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ApiDomain_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ApiDomain_Id_seq" OWNED BY "ApiDomain"."Id";


--
-- Name: ApiExternalUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ApiExternalUser" (
    "Id" integer NOT NULL,
    "Partner" character varying(100) NOT NULL,
    "UserId" integer NOT NULL,
    "ExternalId" character varying(100) NOT NULL,
    "AccountId" integer NOT NULL
);


--
-- Name: ApiExternalUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ApiExternalUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ApiExternalUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ApiExternalUser_Id_seq" OWNED BY "ApiExternalUser"."Id";


--
-- Name: ApiIP; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ApiIP" (
    "Id" integer NOT NULL,
    "AccountId" integer NOT NULL,
    "Ip" inet NOT NULL
);


--
-- Name: ApiIP_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ApiIP_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ApiIP_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ApiIP_Id_seq" OWNED BY "ApiIP"."Id";


--
-- Name: AttributeDefinition; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "AttributeDefinition" (
    "Id" integer NOT NULL,
    "GroupId" integer NOT NULL,
    "ClassName" character varying(255) NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Required" boolean DEFAULT false,
    "Secure" boolean DEFAULT false,
    "Params" json,
    "Order" smallint,
    "Public" boolean DEFAULT true,
    "UseCustomTextField" boolean,
    "Translatable" boolean DEFAULT false NOT NULL
);


--
-- Name: AttributeDefinition_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "AttributeDefinition_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: AttributeDefinition_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "AttributeDefinition_Id_seq" OWNED BY "AttributeDefinition"."Id";


--
-- Name: AttributeGroup; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "AttributeGroup" (
    "Id" integer NOT NULL,
    "ModelName" character varying(255) NOT NULL,
    "ModelId" integer NOT NULL,
    "Title" character varying(255),
    "Description" text,
    "Order" smallint
);


--
-- Name: AttributeGroup_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "AttributeGroup_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: AttributeGroup_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "AttributeGroup_Id_seq" OWNED BY "AttributeGroup"."Id";


--
-- Name: BuduGuruCourse; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "BuduGuruCourse" (
    "Id" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Announce" text NOT NULL,
    "Url" character varying(255) NOT NULL,
    "DateStart" date
);


--
-- Name: CatalogCompany; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CatalogCompany" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Url" character varying(255) DEFAULT NULL::character varying,
    "CompanyId" integer
);


--
-- Name: CatalogCompany_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CatalogCompany_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CatalogCompany_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CatalogCompany_Id_seq" OWNED BY "CatalogCompany"."Id";


--
-- Name: Commission; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "Commission" (
    "Id" integer NOT NULL,
    "Title" character varying(100) NOT NULL,
    "Description" text,
    "Url" character varying(100),
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Deleted" boolean DEFAULT false NOT NULL
);


--
-- Name: CommissionProject; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CommissionProject" (
    "Id" integer NOT NULL,
    "CommissionId" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Description" text,
    "Visible" boolean DEFAULT true NOT NULL
);


--
-- Name: CommissionProjectUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CommissionProjectUser" (
    "Id" integer NOT NULL,
    "ProjectId" integer NOT NULL,
    "UserId" integer NOT NULL
);


--
-- Name: CommissionProjectUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CommissionProjectUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CommissionProjectUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CommissionProjectUser_Id_seq" OWNED BY "CommissionProjectUser"."Id";


--
-- Name: CommissionProject_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CommissionProject_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CommissionProject_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CommissionProject_Id_seq" OWNED BY "CommissionProject"."Id";


--
-- Name: CommissionRole; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CommissionRole" (
    "Id" integer NOT NULL,
    "Title" character varying(100) NOT NULL,
    "Priority" smallint DEFAULT 0 NOT NULL
);


--
-- Name: CommissionRole_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CommissionRole_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CommissionRole_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CommissionRole_Id_seq" OWNED BY "CommissionRole"."Id";


--
-- Name: CommissionUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CommissionUser" (
    "Id" integer NOT NULL,
    "CommissionId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "RoleId" integer NOT NULL,
    "JoinTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "ExitTime" timestamp without time zone
);


--
-- Name: CommissionUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CommissionUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CommissionUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CommissionUser_Id_seq" OWNED BY "CommissionUser"."Id";


--
-- Name: Commission_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Commission_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Commission_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Commission_Id_seq" OWNED BY "Commission"."Id";


--
-- Name: Company; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "Company" (
    "Id" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "FullName" character varying(255) DEFAULT NULL::character varying,
    "Info" text,
    "FullInfo" text,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Code" character varying(255),
    "OGRN" character varying(255),
    "Cluster" "CompanyClusterType"
);


--
-- Name: CompanyLinkAddress; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompanyLinkAddress" (
    "Id" integer NOT NULL,
    "CompanyId" integer,
    "AddressId" integer
);


--
-- Name: CompanyLinkAddress_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CompanyLinkAddress_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CompanyLinkAddress_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CompanyLinkAddress_Id_seq" OWNED BY "CompanyLinkAddress"."Id";


--
-- Name: CompanyLinkCommission; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompanyLinkCommission" (
    "CompanyId" integer NOT NULL,
    "CommissionId" integer NOT NULL
);


--
-- Name: CompanyLinkEmail; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompanyLinkEmail" (
    "Id" integer NOT NULL,
    "CompanyId" integer,
    "EmailId" integer
);


--
-- Name: CompanyLinkEmail_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CompanyLinkEmail_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CompanyLinkEmail_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CompanyLinkEmail_Id_seq" OWNED BY "CompanyLinkEmail"."Id";


--
-- Name: CompanyLinkModerator; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompanyLinkModerator" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "CompanyId" integer NOT NULL
);


--
-- Name: CompanyLinkModerator_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CompanyLinkModerator_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CompanyLinkModerator_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CompanyLinkModerator_Id_seq" OWNED BY "CompanyLinkModerator"."Id";


--
-- Name: CompanyLinkPhone; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompanyLinkPhone" (
    "Id" integer NOT NULL,
    "CompanyId" integer,
    "PhoneId" integer
);


--
-- Name: CompanyLinkPhone_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CompanyLinkPhone_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CompanyLinkPhone_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CompanyLinkPhone_Id_seq" OWNED BY "CompanyLinkPhone"."Id";


--
-- Name: CompanyLinkProfessionalInterest; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompanyLinkProfessionalInterest" (
    "CompanyId" integer NOT NULL,
    "ProfessionalInterestId" integer NOT NULL,
    "Primary" boolean DEFAULT false
);


--
-- Name: CompanyLinkSite; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompanyLinkSite" (
    "Id" integer NOT NULL,
    "CompanyId" integer,
    "SiteId" integer
);


--
-- Name: CompanyLinkSite_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CompanyLinkSite_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CompanyLinkSite_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CompanyLinkSite_Id_seq" OWNED BY "CompanyLinkSite"."Id";


--
-- Name: Company_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Company_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Company_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Company_Id_seq" OWNED BY "Company"."Id";


--
-- Name: PayRoomPartnerBooking; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayRoomPartnerBooking" (
    "Id" integer NOT NULL,
    "ProductId" integer NOT NULL,
    "Owner" character varying(1000),
    "DateIn" date NOT NULL,
    "DateOut" date NOT NULL,
    "ShowPrice" boolean DEFAULT true,
    "Paid" boolean DEFAULT false,
    "PaidTime" timestamp without time zone,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "Deleted" boolean DEFAULT false,
    "DeletionTime" timestamp without time zone,
    "OrderId" integer,
    "AdditionalCount" integer DEFAULT 0,
    "People" text,
    "Car" text
);


--
-- Name: CompetenceQuestion_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CompetenceQuestion_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CompetenceQuestion_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CompetenceQuestion_Id_seq" OWNED BY "PayRoomPartnerBooking"."Id";


--
-- Name: CompetenceQuestion; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompetenceQuestion" (
    "Id" integer DEFAULT nextval('"CompetenceQuestion_Id_seq"'::regclass) NOT NULL,
    "TestId" integer NOT NULL,
    "TypeId" integer NOT NULL,
    "Data" text,
    "PrevQuestionId" integer,
    "NextQuestionId" integer,
    "Code" character varying(255) NOT NULL,
    "Title" character varying(1000),
    "SubTitle" character varying(1000),
    "First" boolean DEFAULT false,
    "Last" boolean DEFAULT false,
    "Sort" integer DEFAULT 0,
    "BeforeTitleText" text,
    "AfterTitleText" text,
    "AfterQuestionText" text,
    "Required" boolean DEFAULT true
);


--
-- Name: CompetenceQuestionType; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompetenceQuestionType" (
    "Id" integer NOT NULL,
    "Class" character varying(255),
    "Title" character varying(1000),
    "Description" text
);


--
-- Name: CompetenceQuestionType_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CompetenceQuestionType_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CompetenceQuestionType_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CompetenceQuestionType_Id_seq" OWNED BY "CompetenceQuestionType"."Id";


--
-- Name: CompetenceResult; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompetenceResult" (
    "Id" integer NOT NULL,
    "TestId" integer NOT NULL,
    "UserId" integer,
    "Data" text,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "Finished" boolean DEFAULT false,
    "UserKey" character varying(255) DEFAULT NULL::character varying
);


--
-- Name: CompetenceResult_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CompetenceResult_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CompetenceResult_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CompetenceResult_Id_seq" OWNED BY "CompetenceResult"."Id";


--
-- Name: CompetenceTest; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "CompetenceTest" (
    "Id" integer NOT NULL,
    "Code" character varying(255) NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Enable" boolean DEFAULT false,
    "Test" boolean DEFAULT true,
    "Info" text,
    "StartButtonText" character varying(255) DEFAULT NULL::character varying,
    "Multiple" boolean DEFAULT false,
    "EndTime" timestamp without time zone,
    "AfterEndText" text,
    "FastAuth" boolean DEFAULT false,
    "FastAuthSecret" character varying(255) DEFAULT NULL::character varying,
    "EventId" integer,
    "StartTime" timestamp without time zone,
    "BeforeText" text,
    "AfterText" text,
    "ParticipantsOnly" boolean DEFAULT false,
    "RoleIdAfterPass" integer,
    "UseClearLayout" boolean DEFAULT false NOT NULL,
    "RenderEventHeader" boolean DEFAULT false NOT NULL
);


--
-- Name: CompetenceTest_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CompetenceTest_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CompetenceTest_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CompetenceTest_Id_seq" OWNED BY "CompetenceTest"."Id";


--
-- Name: ConnectMeeting; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ConnectMeeting" (
    "Id" integer NOT NULL,
    "PlaceId" integer NOT NULL,
    "CreatorId" integer NOT NULL,
    "Date" timestamp without time zone,
    "Type" integer NOT NULL,
    "Purpose" text,
    "Subject" text,
    "File" character varying(255),
    "CreateTime" timestamp without time zone,
    "Status" integer NOT NULL,
    "CancelResponse" text
);


--
-- Name: ConnectMeetingLinkUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ConnectMeetingLinkUser" (
    "Id" integer NOT NULL,
    "MeetingId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "Status" integer NOT NULL,
    "Response" text
);


--
-- Name: ConnectMeetingLinkUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ConnectMeetingLinkUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ConnectMeetingLinkUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ConnectMeetingLinkUser_Id_seq" OWNED BY "ConnectMeetingLinkUser"."Id";


--
-- Name: ConnectMeeting_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ConnectMeeting_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ConnectMeeting_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ConnectMeeting_Id_seq" OWNED BY "ConnectMeeting"."Id";


--
-- Name: ContactAddress; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ContactAddress" (
    "Id" integer NOT NULL,
    "CountryId" integer,
    "RegionId" integer,
    "CityId" integer,
    "PostCode" character varying(20) DEFAULT NULL::character varying,
    "Street" character varying(255) DEFAULT NULL::character varying,
    "House" character varying(100) DEFAULT NULL::character varying,
    "Building" character varying(100) DEFAULT NULL::character varying,
    "Wing" character varying(100) DEFAULT NULL::character varying,
    "Apartment" character varying(100) DEFAULT NULL::character varying,
    "Place" character varying(255) DEFAULT NULL::character varying,
    "GeoPoint" character varying(100)
);


--
-- Name: COLUMN "ContactAddress"."House"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "ContactAddress"."House" IS 'Номер дома';


--
-- Name: COLUMN "ContactAddress"."Building"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "ContactAddress"."Building" IS 'Строение';


--
-- Name: COLUMN "ContactAddress"."Wing"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "ContactAddress"."Wing" IS 'Корпус';


--
-- Name: ContactAddress_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ContactAddress_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ContactAddress_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ContactAddress_Id_seq" OWNED BY "ContactAddress"."Id";


--
-- Name: ContactEmail; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ContactEmail" (
    "Id" integer NOT NULL,
    "Email" character varying(255) NOT NULL,
    "Verified" boolean DEFAULT false NOT NULL,
    "Title" character varying(255)
);


--
-- Name: ContactEmail_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ContactEmail_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ContactEmail_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ContactEmail_Id_seq" OWNED BY "ContactEmail"."Id";


--
-- Name: ContactPhone; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ContactPhone" (
    "Id" integer NOT NULL,
    "CountryCode" character varying(10),
    "CityCode" character varying(10),
    "Phone" character varying(255) NOT NULL,
    "Addon" character varying(10) DEFAULT NULL::character varying,
    "Type" "PhoneType" NOT NULL,
    "Verify" boolean DEFAULT true NOT NULL
);


--
-- Name: ContactPhone_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ContactPhone_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ContactPhone_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ContactPhone_Id_seq" OWNED BY "ContactPhone"."Id";


--
-- Name: ContactServiceAccount; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ContactServiceAccount" (
    "Id" integer NOT NULL,
    "TypeId" integer NOT NULL,
    "Account" character varying(255) NOT NULL
);


--
-- Name: ContactServiceAccount_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ContactServiceAccount_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ContactServiceAccount_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ContactServiceAccount_Id_seq" OWNED BY "ContactServiceAccount"."Id";


--
-- Name: ContactServiceType; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ContactServiceType" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Pattern" text NOT NULL,
    "UrlMask" character varying(255) DEFAULT NULL::character varying,
    "Visible" boolean DEFAULT true NOT NULL
);


--
-- Name: ContactServiceType_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ContactServiceType_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ContactServiceType_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ContactServiceType_Id_seq" OWNED BY "ContactServiceType"."Id";


--
-- Name: ContactSite; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ContactSite" (
    "Id" integer NOT NULL,
    "Url" character varying(255) NOT NULL,
    "Secure" boolean DEFAULT false NOT NULL
);


--
-- Name: ContactSite_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ContactSite_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ContactSite_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ContactSite_Id_seq" OWNED BY "ContactSite"."Id";


--
-- Name: EducationFaculty; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EducationFaculty" (
    "Id" integer NOT NULL,
    "ExtId" integer,
    "UniversityId" integer NOT NULL,
    "Name" character varying(255) NOT NULL
);


--
-- Name: EducationFaculty_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EducationFaculty_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EducationFaculty_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EducationFaculty_Id_seq" OWNED BY "EducationFaculty"."Id";


--
-- Name: EducationUniversity; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EducationUniversity" (
    "Id" integer NOT NULL,
    "ExtId" integer,
    "CityId" integer,
    "Name" character varying(255) NOT NULL,
    "FullName" character varying(1000)
);


--
-- Name: EducationUniversity_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EducationUniversity_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EducationUniversity_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EducationUniversity_Id_seq" OWNED BY "EducationUniversity"."Id";


--
-- Name: Event; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "Event" (
    "Id" integer NOT NULL,
    "IdName" character varying(128) NOT NULL,
    "Title" character varying(1000) NOT NULL,
    "Info" text,
    "FullInfo" text,
    "Visible" boolean DEFAULT false NOT NULL,
    "StartYear" smallint,
    "StartMonth" smallint,
    "StartDay" smallint,
    "EndYear" smallint,
    "EndMonth" smallint,
    "EndDay" smallint,
    "TypeId" smallint DEFAULT 1 NOT NULL,
    "ShowOnMain" boolean DEFAULT false NOT NULL,
    "External" boolean DEFAULT false NOT NULL,
    "Approved" smallint DEFAULT 0 NOT NULL,
    "LogoSource" character(255),
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "FullWidth" boolean DEFAULT false,
    "FbId" character varying(255),
    "Deleted" boolean DEFAULT false NOT NULL,
    "DeletionTime" timestamp without time zone,
    "UserScope" boolean DEFAULT false
);


--
-- Name: EventAttribute; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventAttribute" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Value" text NOT NULL,
    "Order" smallint DEFAULT 0 NOT NULL
);


--
-- Name: EventAttribute_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventAttribute_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventAttribute_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventAttribute_Id_seq" OWNED BY "EventAttribute"."Id";


--
-- Name: EventInvite; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventInvite" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Code" character varying NOT NULL,
    "RoleId" integer NOT NULL,
    "UserId" integer,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "ActivationTime" timestamp without time zone
);


--
-- Name: EventInviteRequest; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventInviteRequest" (
    "Id" integer NOT NULL,
    "OwnerUserId" integer NOT NULL,
    "SenderUserId" integer NOT NULL,
    "EventId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Approved" smallint DEFAULT 0 NOT NULL,
    "ApprovedTime" timestamp without time zone
);


--
-- Name: EventInviteRequest_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventInviteRequest_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventInviteRequest_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventInviteRequest_Id_seq" OWNED BY "EventInviteRequest"."Id";


--
-- Name: EventInvite_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventInvite_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventInvite_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventInvite_Id_seq" OWNED BY "EventInvite"."Id";


--
-- Name: EventLinkAddress; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventLinkAddress" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "AddressId" integer NOT NULL
);


--
-- Name: EventLinkAddress_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventLinkAddress_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventLinkAddress_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventLinkAddress_Id_seq" OWNED BY "EventLinkAddress"."Id";


--
-- Name: EventLinkEmail; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventLinkEmail" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "EmailId" integer NOT NULL
);


--
-- Name: EventLinkEmail_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventLinkEmail_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventLinkEmail_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventLinkEmail_Id_seq" OWNED BY "EventLinkEmail"."Id";


--
-- Name: EventLinkPhone; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventLinkPhone" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "PhoneId" integer NOT NULL
);


--
-- Name: EventLinkPhone_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventLinkPhone_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventLinkPhone_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventLinkPhone_Id_seq" OWNED BY "EventLinkPhone"."Id";


--
-- Name: EventLinkProfessionalInterest; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventLinkProfessionalInterest" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "ProfessionalInterestId" integer NOT NULL
);


--
-- Name: EventLinkProfessionalInterest_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventLinkProfessionalInterest_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventLinkProfessionalInterest_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventLinkProfessionalInterest_Id_seq" OWNED BY "EventLinkProfessionalInterest"."Id";


--
-- Name: EventLinkPurpose; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventLinkPurpose" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "PurposeId" integer NOT NULL
);


--
-- Name: EventLinkPurpose_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventLinkPurpose_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventLinkPurpose_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventLinkPurpose_Id_seq" OWNED BY "EventLinkPurpose"."Id";


--
-- Name: EventLinkRole; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventLinkRole" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "RoleId" integer NOT NULL,
    "Color" character varying(255)
);


--
-- Name: EventLinkRole_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventLinkRole_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventLinkRole_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventLinkRole_Id_seq" OWNED BY "EventLinkRole"."Id";


--
-- Name: EventLinkSite; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventLinkSite" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "SiteId" integer NOT NULL
);


--
-- Name: EventLinkSite_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventLinkSite_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventLinkSite_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventLinkSite_Id_seq" OWNED BY "EventLinkSite"."Id";


--
-- Name: EventLinkTag; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventLinkTag" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "TagId" integer NOT NULL
);


--
-- Name: EventLinkTag_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventLinkTag_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventLinkTag_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventLinkTag_Id_seq" OWNED BY "EventLinkTag"."Id";


--
-- Name: EventLinkWidget; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventLinkWidget" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Order" smallint DEFAULT 0 NOT NULL,
    "ClassId" integer
);


--
-- Name: EventMeetingPlace; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventMeetingPlace" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Reservation" boolean NOT NULL,
    "ReservationTime" integer,
    "ParentId" integer
);


--
-- Name: EventMeetingPlace_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventMeetingPlace_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventMeetingPlace_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventMeetingPlace_Id_seq" OWNED BY "EventMeetingPlace"."Id";


--
-- Name: EventPart; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventPart" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Order" smallint DEFAULT 0 NOT NULL
);


--
-- Name: EventPart_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventPart_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventPart_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventPart_Id_seq" OWNED BY "EventPart"."Id";


--
-- Name: EventParticipant; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventParticipant" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "PartId" integer,
    "UserId" integer NOT NULL,
    "RoleId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "BadgeUID" bigint
);


--
-- Name: EventParticipantLog; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventParticipantLog" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "PartId" integer,
    "UserId" integer NOT NULL,
    "RoleId" integer,
    "Message" text,
    "EditorId" integer,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL
);


--
-- Name: EventParticipantLog_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventParticipantLog_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventParticipantLog_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventParticipantLog_Id_seq" OWNED BY "EventParticipantLog"."Id";


--
-- Name: EventParticipant_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventParticipant_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventParticipant_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventParticipant_Id_seq" OWNED BY "EventParticipant"."Id";


--
-- Name: EventPartner; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventPartner" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "CompanyId" integer NOT NULL,
    "TypeId" integer NOT NULL,
    "Order" smallint DEFAULT 0 NOT NULL
);


--
-- Name: EventPartnerType; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventPartnerType" (
    "Id" integer NOT NULL,
    "EventId" integer,
    "Name" character varying(255) NOT NULL,
    "Order" smallint DEFAULT 0 NOT NULL
);


--
-- Name: EventPartnerType_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventPartnerType_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventPartnerType_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventPartnerType_Id_seq" OWNED BY "EventPartnerType"."Id";


--
-- Name: EventPartner_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventPartner_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventPartner_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventPartner_Id_seq" OWNED BY "EventPartner"."Id";


--
-- Name: EventPurpose; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventPurpose" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Visible" boolean DEFAULT true NOT NULL
);


--
-- Name: EventPurposeLink; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventPurposeLink" (
    "Id" integer NOT NULL,
    "FirstPurposeId" integer NOT NULL,
    "SecondPurposeId" integer NOT NULL
);


--
-- Name: EventPurposeLink_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventPurposeLink_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventPurposeLink_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventPurposeLink_Id_seq" OWNED BY "EventPurposeLink"."Id";


--
-- Name: EventPurpose_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventPurpose_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventPurpose_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventPurpose_Id_seq" OWNED BY "EventPurpose"."Id";


--
-- Name: EventRole; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventRole" (
    "Id" integer NOT NULL,
    "Code" character varying(255) NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Priority" smallint DEFAULT 0 NOT NULL,
    "Type" "RoleType" DEFAULT 'none'::"RoleType" NOT NULL,
    "Base" boolean DEFAULT false NOT NULL,
    "Color" character varying(255),
    "Visible" boolean DEFAULT true,
    "Notification" boolean DEFAULT true
);


--
-- Name: EventRole_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventRole_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventRole_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventRole_Id_seq" OWNED BY "EventRole"."Id";


--
-- Name: EventSection; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSection" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Title" character varying(1000) NOT NULL,
    "Info" text,
    "StartTime" timestamp without time zone NOT NULL,
    "EndTime" timestamp without time zone NOT NULL,
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "TypeId" integer,
    "Code" character varying(255),
    "Deleted" boolean DEFAULT false,
    "DeletionTime" timestamp without time zone,
    "ShortTitle" character varying(1000)
);


--
-- Name: EventSectionAttribute; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionAttribute" (
    "Id" integer NOT NULL,
    "SectionId" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Value" text
);


--
-- Name: EventSectionAttribute_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionAttribute_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionAttribute_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionAttribute_Id_seq" OWNED BY "EventSectionAttribute"."Id";


--
-- Name: EventSectionFavorite; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionFavorite" (
    "Id" integer NOT NULL,
    "SectionId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "Deleted" boolean DEFAULT false,
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: EventSectionFavorite_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionFavorite_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionFavorite_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionFavorite_Id_seq" OWNED BY "EventSectionFavorite"."Id";


--
-- Name: EventSectionHall; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionHall" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Order" smallint DEFAULT 0 NOT NULL,
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "Deleted" boolean DEFAULT false,
    "DeletionTime" timestamp without time zone
);


--
-- Name: EventSectionHall_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionHall_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionHall_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionHall_Id_seq" OWNED BY "EventSectionHall"."Id";


--
-- Name: EventSectionLinkHall; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionLinkHall" (
    "Id" integer NOT NULL,
    "SectionId" integer NOT NULL,
    "HallId" integer NOT NULL
);


--
-- Name: EventSectionLinkHall_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionLinkHall_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionLinkHall_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionLinkHall_Id_seq" OWNED BY "EventSectionLinkHall"."Id";


--
-- Name: EventSectionLinkTheme; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionLinkTheme" (
    "Id" integer NOT NULL,
    "SectionId" integer NOT NULL,
    "ThemeId" integer NOT NULL
);


--
-- Name: EventSectionLinkTheme_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionLinkTheme_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionLinkTheme_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionLinkTheme_Id_seq" OWNED BY "EventSectionLinkTheme"."Id";


--
-- Name: EventSectionLinkUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionLinkUser" (
    "Id" integer NOT NULL,
    "SectionId" integer NOT NULL,
    "UserId" integer,
    "RoleId" integer NOT NULL,
    "ReportId" integer,
    "Order" smallint DEFAULT 0 NOT NULL,
    "CompanyId" integer,
    "CustomText" text,
    "VideoUrl" character varying(255),
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "Deleted" boolean DEFAULT false,
    "DeletionTime" timestamp without time zone
);


--
-- Name: EventSectionLinkUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionLinkUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionLinkUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionLinkUser_Id_seq" OWNED BY "EventSectionLinkUser"."Id";


--
-- Name: EventSectionPartner; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionPartner" (
    "Id" integer NOT NULL,
    "SectionId" integer NOT NULL,
    "CompanyId" integer NOT NULL,
    "Order" smallint DEFAULT 0 NOT NULL
);


--
-- Name: EventSectionPartner_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionPartner_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionPartner_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionPartner_Id_seq" OWNED BY "EventSectionPartner"."Id";


--
-- Name: EventSectionReport; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionReport" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Thesis" text,
    "Url" character varying(1000),
    "FullInfo" text
);


--
-- Name: EventSectionReport_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionReport_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionReport_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionReport_Id_seq" OWNED BY "EventSectionReport"."Id";


--
-- Name: EventSectionRole; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionRole" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Type" "RoleType" DEFAULT 'none'::"RoleType" NOT NULL,
    "Priority" smallint DEFAULT 0 NOT NULL
);


--
-- Name: EventSectionRole_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionRole_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionRole_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionRole_Id_seq" OWNED BY "EventSectionRole"."Id";


--
-- Name: EventSectionTheme; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionTheme" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "ColorBackground" character varying(6) DEFAULT 'ffffff'::character varying NOT NULL,
    "ColorTitle" character varying(6) DEFAULT '000000'::character varying NOT NULL
);


--
-- Name: EventSectionTheme_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionTheme_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionTheme_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionTheme_Id_seq" OWNED BY "EventSectionTheme"."Id";


--
-- Name: EventSectionType; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionType" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Code" character varying(255) NOT NULL
);


--
-- Name: EventSectionType_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionType_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionType_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionType_Id_seq" OWNED BY "EventSectionType"."Id";


--
-- Name: EventSectionUserVisit; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionUserVisit" (
    "Id" integer NOT NULL,
    "HallId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "VisitTime" timestamp without time zone NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "OperatorId" integer NOT NULL
);


--
-- Name: EventSectionUserVisit_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionUserVisit_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionUserVisit_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionUserVisit_Id_seq" OWNED BY "EventSectionUserVisit"."Id";


--
-- Name: EventSectionVote; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventSectionVote" (
    "Id" integer NOT NULL,
    "SectionId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "SpeakerSkill" smallint,
    "ReportInteresting" smallint,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: EventSectionVote_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSectionVote_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSectionVote_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSectionVote_Id_seq" OWNED BY "EventSectionVote"."Id";


--
-- Name: EventSection_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventSection_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventSection_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventSection_Id_seq" OWNED BY "EventSection"."Id";


--
-- Name: EventType; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventType" (
    "Id" integer NOT NULL,
    "Code" character varying(255),
    "Title" character varying(255),
    "Priority" smallint,
    "CssClass" character varying(255)
);


--
-- Name: EventType_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventType_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventType_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventType_Id_seq" OWNED BY "EventType"."Id";


--
-- Name: EventUserAdditionalAttribute; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventUserAdditionalAttribute" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Value" text NOT NULL
);


--
-- Name: EventUserAdditionalAttribute_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventUserAdditionalAttribute_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventUserAdditionalAttribute_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventUserAdditionalAttribute_Id_seq" OWNED BY "EventUserAdditionalAttribute"."Id";


--
-- Name: EventUserData; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventUserData" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "CreatorId" integer,
    "Attributes" json,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "Deleted" boolean DEFAULT false NOT NULL
);


--
-- Name: EventUserData_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventUserData_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventUserData_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventUserData_Id_seq" OWNED BY "EventUserData"."Id";


--
-- Name: EventWidgetClass; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "EventWidgetClass" (
    "Id" integer NOT NULL,
    "Class" character varying(255) NOT NULL,
    "Visible" boolean DEFAULT true NOT NULL
);


--
-- Name: EventWidgetClass_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventWidgetClass_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventWidgetClass_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventWidgetClass_Id_seq" OWNED BY "EventWidgetClass"."Id";


--
-- Name: EventWidget_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "EventWidget_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: EventWidget_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "EventWidget_Id_seq" OWNED BY "EventLinkWidget"."Id";


--
-- Name: Event_EventId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Event_EventId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Event_EventId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Event_EventId_seq" OWNED BY "Event"."Id";


--
-- Name: GeoCity; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "GeoCity" (
    "Id" integer NOT NULL,
    "ExtId" integer,
    "CountryId" integer NOT NULL,
    "RegionId" integer,
    "Name" character varying(255) NOT NULL,
    "Area" character varying(255),
    "Priority" integer DEFAULT 0 NOT NULL,
    "SearchName" tsvector
);


--
-- Name: Geo2City_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Geo2City_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Geo2City_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Geo2City_Id_seq" OWNED BY "GeoCity"."Id";


--
-- Name: GeoCountry; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "GeoCountry" (
    "Id" integer NOT NULL,
    "ExtId" integer,
    "Name" character varying(255) NOT NULL,
    "Priority" integer DEFAULT 0 NOT NULL
);


--
-- Name: Geo2Country_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Geo2Country_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Geo2Country_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Geo2Country_Id_seq" OWNED BY "GeoCountry"."Id";


--
-- Name: GeoRegion; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "GeoRegion" (
    "Id" integer NOT NULL,
    "ExtId" integer,
    "CountryId" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Priority" integer DEFAULT 0 NOT NULL,
    "SearchName" tsvector
);


--
-- Name: Geo2Region_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Geo2Region_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Geo2Region_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Geo2Region_Id_seq" OWNED BY "GeoRegion"."Id";


--
-- Name: IctRole; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "IctRole" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Priority" integer DEFAULT 0 NOT NULL
);


--
-- Name: IctRole_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "IctRole_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: IctRole_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "IctRole_Id_seq" OWNED BY "IctRole"."Id";


--
-- Name: IctUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "IctUser" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "RoleId" integer NOT NULL,
    "Type" character varying(255) NOT NULL,
    "ProfessionalInterestId" integer,
    "JoinTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "ExitTime" timestamp without time zone
);


--
-- Name: IctUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "IctUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: IctUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "IctUser_Id_seq" OWNED BY "IctUser"."Id";


--
-- Name: IriRole; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "IriRole" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Priority" integer DEFAULT 0 NOT NULL
);


--
-- Name: IriRole_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "IriRole_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: IriRole_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "IriRole_Id_seq" OWNED BY "IriRole"."Id";


--
-- Name: IriUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "IriUser" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "RoleId" integer NOT NULL,
    "Type" character varying(255) NOT NULL,
    "ProfessionalInterestId" integer,
    "JoinTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "ExitTime" timestamp without time zone
);


--
-- Name: IriUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "IriUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: IriUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "IriUser_Id_seq" OWNED BY "IriUser"."Id";


--
-- Name: Job; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "Job" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Text" text NOT NULL,
    "SalaryFrom" integer,
    "SalaryTo" integer,
    "CategoryId" integer NOT NULL,
    "PositionId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Visible" boolean DEFAULT true NOT NULL,
    "Url" character varying(255),
    "CompanyId" integer NOT NULL
);


--
-- Name: JobCategory; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "JobCategory" (
    "Id" integer NOT NULL,
    "Title" character varying(100) NOT NULL
);


--
-- Name: JobCategory_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "JobCategory_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: JobCategory_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "JobCategory_Id_seq" OWNED BY "JobCategory"."Id";


--
-- Name: JobCompany; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "JobCompany" (
    "Id" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "LogoUrl" character varying(255)
);


--
-- Name: JobCompany_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "JobCompany_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: JobCompany_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "JobCompany_Id_seq" OWNED BY "JobCompany"."Id";


--
-- Name: JobPosition; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "JobPosition" (
    "Id" integer NOT NULL,
    "Title" character varying(100) NOT NULL
);


--
-- Name: JobPosition_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "JobPosition_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: JobPosition_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "JobPosition_Id_seq" OWNED BY "JobPosition"."Id";


--
-- Name: JobUp; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "JobUp" (
    "Id" integer NOT NULL,
    "JobId" integer NOT NULL,
    "StartTime" timestamp without time zone NOT NULL,
    "EndTime" timestamp without time zone
);


--
-- Name: JobUp_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "JobUp_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: JobUp_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "JobUp_Id_seq" OWNED BY "JobUp"."Id";


--
-- Name: Jobs_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Jobs_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Jobs_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Jobs_Id_seq" OWNED BY "Job"."Id";


--
-- Name: Link; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "Link" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "OwnerId" integer NOT NULL,
    "Approved" integer DEFAULT 0 NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "MeetingTime" timestamp without time zone
);


--
-- Name: Link_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Link_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Link_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Link_Id_seq" OWNED BY "Link"."Id";


--
-- Name: MailLog; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "MailLog" (
    "Id" integer NOT NULL,
    "From" character varying(100) NOT NULL,
    "To" character varying(255) NOT NULL,
    "Subject" character varying(255) NOT NULL,
    "SendTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Hash" character varying(100) NOT NULL,
    "Error" character varying(255)
);


--
-- Name: MailLog_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "MailLog_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: MailLog_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "MailLog_Id_seq" OWNED BY "MailLog"."Id";


--
-- Name: MailTemplate; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "MailTemplate" (
    "Id" integer NOT NULL,
    "Filter" text NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Subject" character varying(255) NOT NULL,
    "From" character varying(255) NOT NULL,
    "FromName" character varying(255) NOT NULL,
    "SendPassbook" boolean DEFAULT false NOT NULL,
    "SendUnsubscribe" boolean DEFAULT false NOT NULL,
    "Active" boolean DEFAULT false NOT NULL,
    "ActivateTime" timestamp without time zone,
    "Success" boolean DEFAULT false NOT NULL,
    "SuccessTime" timestamp without time zone,
    "ViewHash" character varying(100),
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "LastUserId" integer,
    "SendInvisible" boolean DEFAULT false NOT NULL,
    "Layout" character varying(100) DEFAULT 'one-column'::character varying NOT NULL,
    "ShowUnsubscribeLink" boolean DEFAULT true NOT NULL,
    "ShowFooter" boolean DEFAULT true NOT NULL,
    "RelatedEventId" integer,
    "SendUnverified" boolean DEFAULT false NOT NULL,
    "MailerClass" character varying(100) DEFAULT 'PhpMailer'::character varying NOT NULL
);


--
-- Name: MailTemplate_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "MailTemplate_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: MailTemplate_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "MailTemplate_Id_seq" OWNED BY "MailTemplate"."Id";


--
-- Name: News; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "News" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "PreviewText" text,
    "Date" timestamp without time zone NOT NULL,
    "Url" character varying(255) NOT NULL,
    "UrlHash" character varying(32) NOT NULL
);


--
-- Name: News_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "News_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: News_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "News_Id_seq" OWNED BY "News"."Id";


--
-- Name: OAuthAccessToken; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "OAuthAccessToken" (
    "Id" integer NOT NULL,
    "Token" character varying(255) NOT NULL,
    "UserId" integer NOT NULL,
    "AccountId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "EndingTime" timestamp without time zone NOT NULL
);


--
-- Name: OAuthAccessToken_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "OAuthAccessToken_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: OAuthAccessToken_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "OAuthAccessToken_Id_seq" OWNED BY "OAuthAccessToken"."Id";


--
-- Name: OAuthPermission; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "OAuthPermission" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "AccountId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Verified" boolean DEFAULT false NOT NULL,
    "Deleted" boolean DEFAULT false NOT NULL,
    "DeletionTime" timestamp without time zone
);


--
-- Name: OAuthPermission_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "OAuthPermission_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: OAuthPermission_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "OAuthPermission_Id_seq" OWNED BY "OAuthPermission"."Id";


--
-- Name: OAuthSocial; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "OAuthSocial" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "SocialId" integer NOT NULL,
    "Hash" character varying(255) NOT NULL
);


--
-- Name: OAuthSocial_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "OAuthSocial_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: OAuthSocial_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "OAuthSocial_Id_seq" OWNED BY "OAuthSocial"."Id";


--
-- Name: PaperlessDevice; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PaperlessDevice" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "DeviceNumber" integer NOT NULL,
    "Active" boolean,
    "Name" character varying(255),
    "Type" character varying(255),
    "Comment" text
);


--
-- Name: PaperlessDeviceSignal; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PaperlessDeviceSignal" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "DeviceNumber" integer NOT NULL,
    "BadgeUID" bigint NOT NULL,
    "BadgeTime" timestamp without time zone NOT NULL,
    "Processed" boolean DEFAULT false NOT NULL,
    "ProcessedTime" timestamp without time zone,
    "CreatedTime" timestamp without time zone DEFAULT now() NOT NULL
);


--
-- Name: PaperlessDeviceSignal_BadgeId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessDeviceSignal_BadgeId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessDeviceSignal_BadgeId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessDeviceSignal_BadgeId_seq" OWNED BY "PaperlessDeviceSignal"."BadgeUID";


--
-- Name: PaperlessDeviceSignal_DeviceId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessDeviceSignal_DeviceId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessDeviceSignal_DeviceId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessDeviceSignal_DeviceId_seq" OWNED BY "PaperlessDeviceSignal"."DeviceNumber";


--
-- Name: PaperlessDeviceSignal_EventId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessDeviceSignal_EventId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessDeviceSignal_EventId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessDeviceSignal_EventId_seq" OWNED BY "PaperlessDeviceSignal"."EventId";


--
-- Name: PaperlessDeviceSignal_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessDeviceSignal_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessDeviceSignal_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessDeviceSignal_Id_seq" OWNED BY "PaperlessDeviceSignal"."Id";


--
-- Name: PaperlessDevice_DeviceId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessDevice_DeviceId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessDevice_DeviceId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessDevice_DeviceId_seq" OWNED BY "PaperlessDevice"."DeviceNumber";


--
-- Name: PaperlessDevice_EventId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessDevice_EventId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessDevice_EventId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessDevice_EventId_seq" OWNED BY "PaperlessDevice"."EventId";


--
-- Name: PaperlessDevice_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessDevice_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessDevice_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessDevice_Id_seq" OWNED BY "PaperlessDevice"."Id";


--
-- Name: PaperlessEvent; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PaperlessEvent" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Active" boolean,
    "Subject" character varying(255),
    "Text" text,
    "File" character varying(255),
    "SendOnce" boolean,
    "ConditionLike" boolean,
    "ConditionLikeString" character varying(255),
    "ConditionNotLike" boolean,
    "ConditionNotLikeString" character varying(255),
    "Send" boolean DEFAULT false NOT NULL
);


--
-- Name: PaperlessEventLinkDevice; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PaperlessEventLinkDevice" (
    "Id" integer NOT NULL,
    "EventId" integer,
    "DeviceId" integer NOT NULL
);


--
-- Name: PaperlessEventLinkDevice_DeviceId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessEventLinkDevice_DeviceId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessEventLinkDevice_DeviceId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessEventLinkDevice_DeviceId_seq" OWNED BY "PaperlessEventLinkDevice"."DeviceId";


--
-- Name: PaperlessEventLinkDevice_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessEventLinkDevice_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessEventLinkDevice_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessEventLinkDevice_Id_seq" OWNED BY "PaperlessEventLinkDevice"."Id";


--
-- Name: PaperlessEventLinkMaterial; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PaperlessEventLinkMaterial" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "MaterialId" integer NOT NULL
);


--
-- Name: PaperlessEventLinkMaterial_EventId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessEventLinkMaterial_EventId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessEventLinkMaterial_EventId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessEventLinkMaterial_EventId_seq" OWNED BY "PaperlessEventLinkMaterial"."EventId";


--
-- Name: PaperlessEventLinkMaterial_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessEventLinkMaterial_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessEventLinkMaterial_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessEventLinkMaterial_Id_seq" OWNED BY "PaperlessEventLinkMaterial"."Id";


--
-- Name: PaperlessEventLinkMaterial_MaterialId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessEventLinkMaterial_MaterialId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessEventLinkMaterial_MaterialId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessEventLinkMaterial_MaterialId_seq" OWNED BY "PaperlessEventLinkMaterial"."MaterialId";


--
-- Name: PaperlessEventLinkRole; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PaperlessEventLinkRole" (
    "Id" integer NOT NULL,
    "EventId" integer,
    "RoleId" integer
);


--
-- Name: PaperlessEventLinkRole_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessEventLinkRole_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessEventLinkRole_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessEventLinkRole_Id_seq" OWNED BY "PaperlessEventLinkRole"."Id";


--
-- Name: PaperlessEvent_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessEvent_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessEvent_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessEvent_Id_seq" OWNED BY "PaperlessEvent"."Id";


--
-- Name: PaperlessMaterial; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PaperlessMaterial" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Active" boolean,
    "Visible" boolean,
    "Name" character varying(255),
    "File" character varying(255),
    "Comment" text,
    "PartnerName" character varying(255),
    "PartnerSite" character varying(255),
    "PartnerLogo" character varying(255)
);


--
-- Name: PaperlessMaterialLinkRole; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PaperlessMaterialLinkRole" (
    "Id" integer NOT NULL,
    "MaterialId" integer,
    "RoleId" integer
);


--
-- Name: PaperlessMaterialLinkRole_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessMaterialLinkRole_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessMaterialLinkRole_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessMaterialLinkRole_Id_seq" OWNED BY "PaperlessMaterialLinkRole"."Id";


--
-- Name: PaperlessMaterialLinkUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PaperlessMaterialLinkUser" (
    "Id" integer NOT NULL,
    "MaterialId" integer NOT NULL,
    "UserId" integer NOT NULL
);


--
-- Name: PaperlessMaterialLinkUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessMaterialLinkUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessMaterialLinkUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessMaterialLinkUser_Id_seq" OWNED BY "PaperlessMaterialLinkUser"."Id";


--
-- Name: PaperlessMaterialLinkUser_MaterialId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessMaterialLinkUser_MaterialId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessMaterialLinkUser_MaterialId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessMaterialLinkUser_MaterialId_seq" OWNED BY "PaperlessMaterialLinkUser"."MaterialId";


--
-- Name: PaperlessMaterialLinkUser_UserId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessMaterialLinkUser_UserId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessMaterialLinkUser_UserId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessMaterialLinkUser_UserId_seq" OWNED BY "PaperlessMaterialLinkUser"."UserId";


--
-- Name: PaperlessMaterial_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PaperlessMaterial_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PaperlessMaterial_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PaperlessMaterial_Id_seq" OWNED BY "PaperlessMaterial"."Id";


--
-- Name: PartnerAccount; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PartnerAccount" (
    "Id" integer NOT NULL,
    "EventId" integer,
    "Login" character varying(100) NOT NULL,
    "Password" character varying(100),
    "NoticeEmail" character varying(100),
    "Role" character varying(100) DEFAULT 'Partner'::character varying NOT NULL,
    "PasswordStrong" character varying(1000),
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: PartnerAccount_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PartnerAccount_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PartnerAccount_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PartnerAccount_Id_seq" OWNED BY "PartnerAccount"."Id";


--
-- Name: PartnerCallback; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PartnerCallback" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "ExternalKey" character varying(255),
    "RegisterCallback" character varying(1000) DEFAULT NULL::character varying,
    "TryPayCallback" character varying(1000) DEFAULT NULL::character varying,
    "PayCallback" character varying(1000) DEFAULT NULL::character varying,
    "OrderItemCallback" character varying(1000) DEFAULT NULL::character varying
);


--
-- Name: PartnerCallbackUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PartnerCallbackUser" (
    "Id" integer NOT NULL,
    "PartnerCallbackId" integer,
    "UserId" integer,
    "Key" character varying(255),
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: PartnerCallbackUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PartnerCallbackUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PartnerCallbackUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PartnerCallbackUser_Id_seq" OWNED BY "PartnerCallbackUser"."Id";


--
-- Name: PartnerCallback_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PartnerCallback_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PartnerCallback_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PartnerCallback_Id_seq" OWNED BY "PartnerCallback"."Id";


--
-- Name: PartnerExport; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PartnerExport" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Config" json NOT NULL,
    "UserId" integer NOT NULL,
    "TotalRow" integer,
    "ExportedRow" integer,
    "Success" boolean DEFAULT false NOT NULL,
    "SuccessTime" timestamp without time zone,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "FilePath" character varying(255)
);


--
-- Name: PartnerExport_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PartnerExport_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PartnerExport_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PartnerExport_Id_seq" OWNED BY "PartnerExport"."Id";


--
-- Name: PartnerImport; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PartnerImport" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Fields" text,
    "Roles" text,
    "Notify" boolean DEFAULT false,
    "NotifyEvent" boolean DEFAULT false,
    "Visible" boolean DEFAULT false,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "Products" text
);


--
-- Name: PartnerImportUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PartnerImportUser" (
    "Id" integer NOT NULL,
    "ImportId" integer NOT NULL,
    "LastName" character varying(255),
    "FirstName" character varying(255),
    "FatherName" character varying(255),
    "Email" character varying(255),
    "Phone" character varying(255),
    "Company" character varying(255),
    "Position" character varying(255),
    "Role" character varying(255),
    "Imported" boolean DEFAULT false,
    "Error" boolean DEFAULT false,
    "ErrorMessage" character varying(255),
    "Product" character varying(255),
    "ExternalId" character varying(255),
    "UserData" json,
    "LastName_en" character varying(255),
    "FirstName_en" character varying(255),
    "FatherName_en" character varying(255),
    "PhotoUrl" character varying(1000),
    "PhotoNameInPath" character varying(1000),
    "Company_en" character varying(255)
);


--
-- Name: PartnerImportUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PartnerImportUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PartnerImportUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PartnerImportUser_Id_seq" OWNED BY "PartnerImportUser"."Id";


--
-- Name: PartnerImport_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PartnerImport_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PartnerImport_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PartnerImport_Id_seq" OWNED BY "PartnerImport"."Id";


--
-- Name: PayAccount; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayAccount" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Own" boolean DEFAULT true NOT NULL,
    "ReturnUrl" character varying(255),
    "Offer" character varying(255),
    "OrderLastTime" timestamp without time zone,
    "OrderEnable" boolean DEFAULT true,
    "Uniteller" boolean DEFAULT false,
    "PayOnline" boolean DEFAULT false,
    "OrderTemplateId" integer,
    "SandBoxUser" boolean DEFAULT false,
    "ReceiptName" character varying(255) DEFAULT NULL::character varying,
    "ReceiptId" integer,
    "ReceiptLastTime" timestamp without time zone,
    "ReceiptEnable" boolean DEFAULT false,
    "SandBoxUserRegisterUrl" character varying(1000) DEFAULT NULL::character varying,
    "ReceiptTemplateId" integer,
    "MailRuMoney" boolean DEFAULT true,
    "OrderDisableMessage" text,
    "UnitellerRuvents" boolean DEFAULT true,
    "OrderMinTotal" integer,
    "OrderMinTotalMessage" text,
    "ApiReturnUrl" character varying(255),
    "AfterPayUrl" character varying(255),
    "CloudPayments" boolean DEFAULT false,
    "CabinetIndexTabTitle" character varying(255),
    "CabinetHasRecentPaidItemsMessage" character varying(255),
    "CabinetJuridicalCreateInfo" character varying(255),
    "WalletOne" boolean DEFAULT false,
    "PayOnlineRuvents" boolean DEFAULT false
);


--
-- Name: PayAccount_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayAccount_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayAccount_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayAccount_Id_seq" OWNED BY "PayAccount"."Id";


--
-- Name: PayCollectionCoupon; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayCollectionCoupon" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Type" character varying(255) NOT NULL,
    "Discount" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "StartTime" timestamp without time zone,
    "EndTime" timestamp without time zone
);


--
-- Name: PayCollectionCouponAttribute; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayCollectionCouponAttribute" (
    "Id" integer NOT NULL,
    "CollectionCouponId" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Value" text
);


--
-- Name: PayCollectionCouponAttribute_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayCollectionCouponAttribute_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayCollectionCouponAttribute_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayCollectionCouponAttribute_Id_seq" OWNED BY "PayCollectionCouponAttribute"."Id";


--
-- Name: PayCollectionCouponLinkProduct; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayCollectionCouponLinkProduct" (
    "CollectionCouponId" integer NOT NULL,
    "ProductId" integer NOT NULL
);


--
-- Name: PayCollectionCoupon_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayCollectionCoupon_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayCollectionCoupon_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayCollectionCoupon_Id_seq" OWNED BY "PayCollectionCoupon"."Id";


--
-- Name: PayCoupon; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayCoupon" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Code" character varying(255) NOT NULL,
    "Discount" integer NOT NULL,
    "Recipient" text,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "EndTime" timestamp without time zone,
    "Multiple" boolean DEFAULT false NOT NULL,
    "MultipleCount" integer,
    "IsTicket" boolean DEFAULT false NOT NULL,
    "OwnerId" integer,
    "Deleted" boolean DEFAULT false,
    "DeletionTime" timestamp without time zone,
    "ManagerName" character varying(255) DEFAULT 'Percent'::character varying NOT NULL
);


--
-- Name: PayCouponActivation; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayCouponActivation" (
    "Id" integer NOT NULL,
    "CouponId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL
);


--
-- Name: PayCouponActivated_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayCouponActivated_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayCouponActivated_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayCouponActivated_Id_seq" OWNED BY "PayCouponActivation"."Id";


--
-- Name: PayCouponActivationLinkOrderItem; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayCouponActivationLinkOrderItem" (
    "Id" integer NOT NULL,
    "CouponActivationId" integer NOT NULL,
    "OrderItemId" integer NOT NULL
);


--
-- Name: PayCouponActivationLinkOrderItem_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayCouponActivationLinkOrderItem_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayCouponActivationLinkOrderItem_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayCouponActivationLinkOrderItem_Id_seq" OWNED BY "PayCouponActivationLinkOrderItem"."Id";


--
-- Name: PayCouponLinkProduct; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayCouponLinkProduct" (
    "CouponId" integer NOT NULL,
    "ProductId" integer NOT NULL
);


--
-- Name: PayCoupon_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayCoupon_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayCoupon_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayCoupon_Id_seq" OWNED BY "PayCoupon"."Id";


--
-- Name: PayFoodPartnerOrder; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayFoodPartnerOrder" (
    "Id" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Address" character varying(255) NOT NULL,
    "INN" character varying(255) NOT NULL,
    "KPP" character varying(255) NOT NULL,
    "BankName" character varying(255) NOT NULL,
    "Account" character varying(255) NOT NULL,
    "CorrespondentAccount" character varying(255) NOT NULL,
    "BIK" character varying(255) NOT NULL,
    "ChiefName" character varying(255) NOT NULL,
    "ChiefPosition" character varying(255) NOT NULL,
    "ChiefNameP" character varying(255) NOT NULL,
    "ChiefPositionP" character varying(255) NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "Paid" boolean DEFAULT false,
    "PaidTime" timestamp without time zone,
    "Deleted" boolean DEFAULT false,
    "DeletionTime" timestamp without time zone,
    "StatuteTitle" character varying(255),
    "RealAddress" character varying(255),
    "EventId" integer NOT NULL,
    "Number" character varying(255) NOT NULL,
    "Owner" character varying(255) NOT NULL
);


--
-- Name: PayFoodPartnerOrderItem; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayFoodPartnerOrderItem" (
    "Id" integer NOT NULL,
    "ProductId" integer NOT NULL,
    "Paid" boolean DEFAULT false,
    "PaidTime" timestamp without time zone,
    "Deleted" boolean DEFAULT false,
    "DeletionTime" timestamp without time zone,
    "OrderId" integer,
    "Count" integer DEFAULT 0,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: PayFoodPartnerOrderItem_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayFoodPartnerOrderItem_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayFoodPartnerOrderItem_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayFoodPartnerOrderItem_Id_seq" OWNED BY "PayFoodPartnerOrderItem"."Id";


--
-- Name: PayFoodPartnerOrder_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayFoodPartnerOrder_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayFoodPartnerOrder_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayFoodPartnerOrder_Id_seq" OWNED BY "PayFoodPartnerOrder"."Id";


--
-- Name: PayLoyaltyProgramDiscount; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayLoyaltyProgramDiscount" (
    "Id" integer NOT NULL,
    "ProductId" integer,
    "Discount" integer NOT NULL,
    "StartTime" timestamp without time zone,
    "EndTime" timestamp without time zone,
    "EventId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL
);


--
-- Name: PayLoayaltyProgram_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayLoayaltyProgram_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayLoayaltyProgram_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayLoayaltyProgram_Id_seq" OWNED BY "PayLoyaltyProgramDiscount"."Id";


--
-- Name: PayLog; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayLog" (
    "Id" integer NOT NULL,
    "Message" text NOT NULL,
    "Code" smallint,
    "Info" text NOT NULL,
    "Error" boolean DEFAULT true NOT NULL,
    "OrderId" integer,
    "Total" integer,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "PaySystem" character varying(255),
    "NotificationSent" boolean DEFAULT false
);


--
-- Name: PayLog_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayLog_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayLog_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayLog_Id_seq" OWNED BY "PayLog"."Id";


--
-- Name: PayOrder; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayOrder" (
    "Id" integer NOT NULL,
    "PayerId" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Paid" boolean DEFAULT false NOT NULL,
    "PaidTime" timestamp without time zone,
    "Total" integer,
    "Juridical" boolean DEFAULT false NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Deleted" boolean DEFAULT false NOT NULL,
    "DeletionTime" timestamp without time zone,
    "Receipt" boolean DEFAULT false,
    "TemplateId" integer,
    "Number" character varying(255) DEFAULT NULL::character varying,
    "Type" integer,
    "System" character varying(255)
);


--
-- Name: PayOrderImport; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayOrderImport" (
    "Id" integer NOT NULL,
    "CreationTime" timestamp without time zone
);


--
-- Name: PayOrderImportEntry; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayOrderImportEntry" (
    "Id" integer NOT NULL,
    "ImportId" integer NOT NULL,
    "Data" text NOT NULL
);


--
-- Name: PayOrderImportOrder; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayOrderImportOrder" (
    "Id" integer NOT NULL,
    "EntryId" integer NOT NULL,
    "OrderId" integer,
    "Approved" boolean
);


--
-- Name: PayOrderImportOrder_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayOrderImportOrder_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayOrderImportOrder_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayOrderImportOrder_Id_seq" OWNED BY "PayOrderImportEntry"."Id";


--
-- Name: PayOrderImportOrder_Id_seq1; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayOrderImportOrder_Id_seq1"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayOrderImportOrder_Id_seq1; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayOrderImportOrder_Id_seq1" OWNED BY "PayOrderImportOrder"."Id";


--
-- Name: PayOrderImport_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayOrderImport_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayOrderImport_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayOrderImport_Id_seq" OWNED BY "PayOrderImport"."Id";


--
-- Name: PayOrderItem; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayOrderItem" (
    "Id" integer NOT NULL,
    "ProductId" integer NOT NULL,
    "PayerId" integer NOT NULL,
    "OwnerId" integer NOT NULL,
    "ChangedOwnerId" integer,
    "Booked" timestamp without time zone,
    "Paid" boolean DEFAULT false NOT NULL,
    "PaidTime" timestamp without time zone,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Deleted" boolean DEFAULT false NOT NULL,
    "DeletionTime" timestamp without time zone,
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "Refund" boolean DEFAULT false,
    "RefundTime" timestamp without time zone
);


--
-- Name: PayOrderItemAttribute; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayOrderItemAttribute" (
    "Id" integer NOT NULL,
    "OrderItemId" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Value" character varying(255) NOT NULL
);


--
-- Name: PayOrderItemAttribute_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayOrderItemAttribute_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayOrderItemAttribute_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayOrderItemAttribute_Id_seq" OWNED BY "PayOrderItemAttribute"."Id";


--
-- Name: PayOrderItem_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayOrderItem_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayOrderItem_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayOrderItem_Id_seq" OWNED BY "PayOrderItem"."Id";


--
-- Name: PayOrderJuridical; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayOrderJuridical" (
    "Id" integer NOT NULL,
    "OrderId" integer NOT NULL,
    "Name" text,
    "Address" text,
    "INN" character varying(255),
    "KPP" character varying(255),
    "Phone" character varying(255),
    "Fax" character varying(255),
    "PostAddress" text,
    "ExternalKey" character varying(255) DEFAULT NULL::character varying,
    "UrlPay" character varying(1000) DEFAULT NULL::character varying
);


--
-- Name: PayOrderJuridicalTemplate; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayOrderJuridicalTemplate" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Recipient" character varying(255) NOT NULL,
    "Address" character varying(1000) NOT NULL,
    "Phone" character varying(100) NOT NULL,
    "Fax" character varying(100),
    "INN" character varying(100) NOT NULL,
    "KPP" character varying(100) DEFAULT NULL::character varying,
    "Bank" character varying(255) NOT NULL,
    "AccountNumber" character varying(100) NOT NULL,
    "BankAccountNumber" character varying(100) NOT NULL,
    "BIK" character varying(100) NOT NULL,
    "SignFirstTitle" character varying(100) DEFAULT NULL::character varying,
    "SignSecondTitle" character varying(100) DEFAULT NULL::character varying,
    "SignFirstName" character varying(100) DEFAULT NULL::character varying,
    "SignSecondName" character varying(100) DEFAULT NULL::character varying,
    "VAT" boolean DEFAULT true NOT NULL,
    "SignFirstImageMargin" point,
    "SignSecondImageMargin" point,
    "StampImageMargin" point,
    "OrderTemplateName" character varying(255) DEFAULT NULL::character varying,
    "NumberFormat" character varying(255) DEFAULT NULL::character varying,
    "Number" integer DEFAULT 1,
    "ParentTemplateId" integer,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "OfferText" text,
    "ValidityDays" integer DEFAULT 5 NOT NULL,
    "ShowValidity" boolean DEFAULT true
);


--
-- Name: PayOrderJuridicalTemplate_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayOrderJuridicalTemplate_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayOrderJuridicalTemplate_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayOrderJuridicalTemplate_Id_seq" OWNED BY "PayOrderJuridicalTemplate"."Id";


--
-- Name: PayOrderJuridical_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayOrderJuridical_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayOrderJuridical_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayOrderJuridical_Id_seq" OWNED BY "PayOrderJuridical"."Id";


--
-- Name: PayOrderLinkOrderItem; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayOrderLinkOrderItem" (
    "Id" integer NOT NULL,
    "OrderId" integer NOT NULL,
    "OrderItemId" integer NOT NULL
);


--
-- Name: PayOrderLinkOrderItem_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayOrderLinkOrderItem_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayOrderLinkOrderItem_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayOrderLinkOrderItem_Id_seq" OWNED BY "PayOrderLinkOrderItem"."Id";


--
-- Name: PayOrder_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayOrder_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayOrder_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayOrder_Id_seq" OWNED BY "PayOrder"."Id";


--
-- Name: PayProduct; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayProduct" (
    "Id" integer NOT NULL,
    "ManagerName" character varying(255) NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Description" text,
    "EventId" integer NOT NULL,
    "Unit" character varying(255) NOT NULL,
    "Count" integer,
    "EnableCoupon" boolean DEFAULT true NOT NULL,
    "Public" boolean DEFAULT true NOT NULL,
    "Priority" integer DEFAULT 0 NOT NULL,
    "AdditionalAttributes" text,
    "AdditionalAttributesTitle" character varying(1000) DEFAULT NULL::character varying,
    "OrderTitle" text,
    "GroupName" text,
    "VisibleForRuvents" boolean DEFAULT true NOT NULL,
    "Deleted" boolean DEFAULT false,
    "DeletionTime" timestamp without time zone
);


--
-- Name: PayProductAttribute; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayProductAttribute" (
    "Id" integer NOT NULL,
    "ProductId" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Value" character varying(255) NOT NULL,
    "Deleted" boolean DEFAULT false,
    "DeletionTime" timestamp without time zone
);


--
-- Name: PayProductAttribute_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayProductAttribute_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayProductAttribute_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayProductAttribute_Id_seq" OWNED BY "PayProductAttribute"."Id";


--
-- Name: PayProductCheck; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayProductCheck" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "ProductId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "OperatorId" integer,
    "CheckTime" timestamp without time zone
);


--
-- Name: PayProductGet_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayProductGet_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayProductGet_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayProductGet_Id_seq" OWNED BY "PayProductCheck"."Id";


--
-- Name: PayProductPrice; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayProductPrice" (
    "Id" integer NOT NULL,
    "ProductId" integer NOT NULL,
    "Price" integer NOT NULL,
    "StartTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "EndTime" timestamp without time zone,
    "Title" character varying(100),
    "Deleted" boolean DEFAULT false,
    "DeletionTime" timestamp without time zone
);


--
-- Name: PayProductPrice_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayProductPrice_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayProductPrice_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayProductPrice_Id_seq" OWNED BY "PayProductPrice"."Id";


--
-- Name: PayProductUserAccess; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayProductUserAccess" (
    "Id" integer NOT NULL,
    "ProductId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: PayProductUserAccess_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayProductUserAccess_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayProductUserAccess_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayProductUserAccess_Id_seq" OWNED BY "PayProductUserAccess"."Id";


--
-- Name: PayProduct_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayProduct_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayProduct_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayProduct_Id_seq" OWNED BY "PayProduct"."Id";


--
-- Name: PayReferralDiscount; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayReferralDiscount" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "ProductId" integer,
    "Discount" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "StartTime" timestamp without time zone,
    "EndTime" timestamp without time zone
);


--
-- Name: PayReferralDiscount_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayReferralDiscount_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayReferralDiscount_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayReferralDiscount_Id_seq" OWNED BY "PayReferralDiscount"."Id";


--
-- Name: PayRoomPartnerBooking_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayRoomPartnerBooking_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayRoomPartnerBooking_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayRoomPartnerBooking_Id_seq" OWNED BY "PayRoomPartnerBooking"."Id";


--
-- Name: PayRoomPartnerOrder; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "PayRoomPartnerOrder" (
    "Id" integer NOT NULL,
    "Name" character varying NOT NULL,
    "Address" character varying(1000) NOT NULL,
    "INN" character varying NOT NULL,
    "KPP" character varying NOT NULL,
    "BankName" character varying NOT NULL,
    "Account" character varying NOT NULL,
    "CorrespondentAccount" character varying NOT NULL,
    "BIK" character varying NOT NULL,
    "ChiefName" character varying NOT NULL,
    "ChiefPosition" character varying NOT NULL,
    "ChiefNameP" character varying NOT NULL,
    "ChiefPositionP" character varying NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Paid" boolean DEFAULT false NOT NULL,
    "PaidTime" timestamp without time zone,
    "Deleted" boolean DEFAULT false NOT NULL,
    "DeletionTime" timestamp without time zone,
    "StatuteTitle" character varying(255),
    "RealAddress" character varying(1000),
    "Number" character varying(255),
    "EventId" integer
);


--
-- Name: PayRoomPartnerOrder_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "PayRoomPartnerOrder_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: PayRoomPartnerOrder_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "PayRoomPartnerOrder_Id_seq" OWNED BY "PayRoomPartnerOrder"."Id";


--
-- Name: ProfessionalInterest; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ProfessionalInterest" (
    "Id" integer NOT NULL,
    "Code" character varying(255) NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Description" text,
    "En" character varying(100)
);


--
-- Name: ProfessionalInterest_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ProfessionalInterest_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ProfessionalInterest_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ProfessionalInterest_Id_seq" OWNED BY "ProfessionalInterest"."Id";


--
-- Name: RaecBrief; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RaecBrief" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Data" json NOT NULL
);


--
-- Name: RaecBriefLinkCompany; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RaecBriefLinkCompany" (
    "Id" integer NOT NULL,
    "BriefId" integer NOT NULL,
    "CompanyId" integer NOT NULL,
    "Primary" boolean DEFAULT false NOT NULL
);


--
-- Name: RaecBriefCompany_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RaecBriefCompany_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RaecBriefCompany_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RaecBriefCompany_Id_seq" OWNED BY "RaecBriefLinkCompany"."Id";


--
-- Name: RaecBriefLinkUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RaecBriefLinkUser" (
    "Id" integer NOT NULL,
    "BriefId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "RoleId" integer NOT NULL
);


--
-- Name: RaecBriefLinkUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RaecBriefLinkUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RaecBriefLinkUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RaecBriefLinkUser_Id_seq" OWNED BY "RaecBriefLinkUser"."Id";


--
-- Name: RaecBriefUserRole; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RaecBriefUserRole" (
    "Id" integer NOT NULL,
    "Title" character varying(255)
);


--
-- Name: RaecBriefUserRole_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RaecBriefUserRole_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RaecBriefUserRole_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RaecBriefUserRole_Id_seq" OWNED BY "RaecBriefUserRole"."Id";


--
-- Name: RaecBrief_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RaecBrief_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RaecBrief_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RaecBrief_Id_seq" OWNED BY "RaecBrief"."Id";


--
-- Name: RaecCompanyUser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RaecCompanyUser" (
    "Id" integer NOT NULL,
    "CompanyId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "StatusId" integer NOT NULL,
    "JoinTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    "ExitTime" timestamp without time zone,
    "AllowVote" boolean DEFAULT false,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: RaecCompanyUserStatus; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RaecCompanyUserStatus" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL
);


--
-- Name: RaecCompanyUserStatus_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RaecCompanyUserStatus_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RaecCompanyUserStatus_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RaecCompanyUserStatus_Id_seq" OWNED BY "RaecCompanyUserStatus"."Id";


--
-- Name: RaecCompanyUser_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RaecCompanyUser_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RaecCompanyUser_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RaecCompanyUser_Id_seq" OWNED BY "RaecCompanyUser"."Id";


--
-- Name: RuventsAccount; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RuventsAccount" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Hash" character varying(255) NOT NULL,
    "Role" character varying(255) DEFAULT 'Server'::character varying
);


--
-- Name: RuventsAccount_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RuventsAccount_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RuventsAccount_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RuventsAccount_Id_seq" OWNED BY "RuventsAccount"."Id";


--
-- Name: RuventsBadge; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RuventsBadge" (
    "Id" integer NOT NULL,
    "OperatorId" integer NOT NULL,
    "EventId" integer NOT NULL,
    "PartId" integer,
    "UserId" integer NOT NULL,
    "RoleId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL
);


--
-- Name: RuventsBadge_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RuventsBadge_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RuventsBadge_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RuventsBadge_Id_seq" OWNED BY "RuventsBadge"."Id";


--
-- Name: RuventsDetailLog; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RuventsDetailLog" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "OperatorId" integer,
    "UserId" integer,
    "Controller" character varying(255) NOT NULL,
    "Action" character varying(255) NOT NULL,
    "Changes" text NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL
);


--
-- Name: RuventsDetailLog_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RuventsDetailLog_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RuventsDetailLog_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RuventsDetailLog_Id_seq" OWNED BY "RuventsDetailLog"."Id";


--
-- Name: RuventsOperator; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RuventsOperator" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Login" character varying(255) NOT NULL,
    "Password" character varying(255) NOT NULL,
    "Role" character varying(255) NOT NULL,
    "LastLoginTime" timestamp without time zone
);


--
-- Name: RuventsOperator_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RuventsOperator_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RuventsOperator_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RuventsOperator_Id_seq" OWNED BY "RuventsOperator"."Id";


--
-- Name: RuventsSetting; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RuventsSetting" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "Attributes" json NOT NULL
);


--
-- Name: RuventsSetting_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RuventsSetting_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RuventsSetting_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RuventsSetting_Id_seq" OWNED BY "RuventsSetting"."Id";


--
-- Name: RuventsVisit; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "RuventsVisit" (
    "Id" integer NOT NULL,
    "EventId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "MarkId" character varying(255) NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: RuventsVisit_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "RuventsVisit_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: RuventsVisit_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "RuventsVisit_Id_seq" OWNED BY "RuventsVisit"."Id";


--
-- Name: ShortUrl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "ShortUrl" (
    "Id" integer NOT NULL,
    "Hash" character varying(100) NOT NULL,
    "Url" character varying(255) NOT NULL
);


--
-- Name: ShortUrl_Id_seq1; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "ShortUrl_Id_seq1"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ShortUrl_Id_seq1; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "ShortUrl_Id_seq1" OWNED BY "ShortUrl"."Id";


--
-- Name: Tag; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "Tag" (
    "Id" integer NOT NULL,
    "Name" character varying(255) NOT NULL,
    "Title" character varying(255) NOT NULL,
    "Verified" boolean DEFAULT false NOT NULL
);


--
-- Name: Tag_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Tag_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Tag_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Tag_Id_seq" OWNED BY "Tag"."Id";


--
-- Name: TmpRifParking; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "TmpRifParking" (
    "Id" integer NOT NULL,
    "Brand" character varying(100),
    "Model" character varying(100),
    "Number" character varying(100) NOT NULL,
    "Hotel" character varying(100) NOT NULL,
    "DateIn" date NOT NULL,
    "DateOut" date NOT NULL,
    "Status" character varying(30) NOT NULL,
    "EventId" integer
);


--
-- Name: TmpRifParking_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "TmpRifParking_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: TmpRifParking_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "TmpRifParking_Id_seq" OWNED BY "TmpRifParking"."Id";


--
-- Name: Translation; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "Translation" (
    "Id" integer NOT NULL,
    "ResourceName" character varying(255) NOT NULL,
    "ResourceId" integer NOT NULL,
    "Locale" character varying(10) NOT NULL,
    "Field" character varying(255) NOT NULL,
    "Value" text NOT NULL
);


--
-- Name: Translation_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Translation_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Translation_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Translation_Id_seq" OWNED BY "Translation"."Id";


--
-- Name: User; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "User" (
    "Id" integer NOT NULL,
    "LastName" character varying(100) NOT NULL,
    "FirstName" character varying(100) NOT NULL,
    "FatherName" character varying(100),
    "Birthday" date,
    "Password" character varying(255) DEFAULT NULL::character varying,
    "Email" character varying(255) NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "LastVisit" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "OldPassword" character varying(32) DEFAULT NULL::character varying,
    "RunetId" integer NOT NULL,
    "Gender" "Gender" DEFAULT 'none'::"Gender" NOT NULL,
    "Visible" boolean DEFAULT true NOT NULL,
    "Temporary" boolean DEFAULT false NOT NULL,
    "Language" character varying(2) DEFAULT NULL::character varying,
    "PrimaryPhone" character varying(255),
    "PrimaryPhoneVerify" boolean DEFAULT false,
    "PrimaryPhoneVerifyTime" timestamp without time zone,
    "MergeUserId" integer,
    "MergeTime" timestamp without time zone,
    "SearchFirstName" tsvector,
    "SearchLastName" tsvector,
    "Verified" boolean DEFAULT false NOT NULL,
    "PayonlineRebill" character varying(255)
);


--
-- Name: UserDevice; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserDevice" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "Type" "DeviceType" NOT NULL,
    "Token" text NOT NULL,
    "SnsEndpointArn" text NOT NULL,
    "SnsSubscriptionArn" text NOT NULL,
    "Deleted" boolean DEFAULT false,
    "DeleteTime" timestamp without time zone,
    "CreateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "UpdateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL
);


--
-- Name: UserDevice_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserDevice_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserDevice_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserDevice_Id_seq" OWNED BY "UserDevice"."Id";


--
-- Name: UserDocument; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserDocument" (
    "Id" integer NOT NULL,
    "TypeId" integer NOT NULL,
    "UserId" integer NOT NULL,
    "Attributes" json NOT NULL,
    "Actual" boolean DEFAULT true,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: UserDocumentType; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserDocumentType" (
    "Id" integer NOT NULL,
    "Title" character varying(255) NOT NULL,
    "FormName" character varying(255) NOT NULL
);


--
-- Name: UserDocumentType_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserDocumentType_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserDocumentType_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserDocumentType_Id_seq" OWNED BY "UserDocumentType"."Id";


--
-- Name: UserDocument_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserDocument_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserDocument_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserDocument_Id_seq" OWNED BY "UserDocument"."Id";


--
-- Name: UserEducation; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserEducation" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "UniversityId" integer NOT NULL,
    "FacultyId" integer,
    "Specialty" character varying(255) NOT NULL,
    "EndYear" integer,
    "Degree" "EducationDegree"
);


--
-- Name: UserEducation_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserEducation_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserEducation_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserEducation_Id_seq" OWNED BY "UserEducation"."Id";


--
-- Name: UserEmployment; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserEmployment" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "CompanyId" integer NOT NULL,
    "Position" character varying(255) DEFAULT NULL::character varying,
    "Primary" boolean DEFAULT false NOT NULL,
    "StartYear" smallint,
    "StartMonth" smallint,
    "EndYear" smallint,
    "EndMonth" smallint
);


--
-- Name: UserEmployment_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserEmployment_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserEmployment_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserEmployment_Id_seq" OWNED BY "UserEmployment"."Id";


--
-- Name: UserLinkAddress; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserLinkAddress" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "AddressId" integer NOT NULL
);


--
-- Name: UserLinkAddress_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserLinkAddress_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserLinkAddress_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserLinkAddress_Id_seq" OWNED BY "UserLinkAddress"."Id";


--
-- Name: UserLinkEmail; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserLinkEmail" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "EmailId" integer NOT NULL
);


--
-- Name: UserLinkEmail_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserLinkEmail_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserLinkEmail_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserLinkEmail_Id_seq" OWNED BY "UserLinkEmail"."Id";


--
-- Name: UserLinkPhone; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserLinkPhone" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "PhoneId" integer NOT NULL
);


--
-- Name: UserLinkPhone_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserLinkPhone_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserLinkPhone_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserLinkPhone_Id_seq" OWNED BY "UserLinkPhone"."Id";


--
-- Name: UserLinkProfessionalInterest; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserLinkProfessionalInterest" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "ProfessionalInterestId" integer NOT NULL
);


--
-- Name: UserLinkProfessionalInterest_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserLinkProfessionalInterest_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserLinkProfessionalInterest_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserLinkProfessionalInterest_Id_seq" OWNED BY "UserLinkProfessionalInterest"."Id";


--
-- Name: UserLinkServiceAccount; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserLinkServiceAccount" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "ServiceAccountId" integer NOT NULL
);


--
-- Name: UserLinkServiceAccount_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserLinkServiceAccount_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserLinkServiceAccount_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserLinkServiceAccount_Id_seq" OWNED BY "UserLinkServiceAccount"."Id";


--
-- Name: UserLinkSite; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserLinkSite" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "SiteId" integer NOT NULL
);


--
-- Name: UserLinkSite_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserLinkSite_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserLinkSite_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserLinkSite_Id_seq" OWNED BY "UserLinkSite"."Id";


--
-- Name: UserLoyaltyProgram; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserLoyaltyProgram" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "EventId" integer,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: UserLoyaltyProgram_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserLoyaltyProgram_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserLoyaltyProgram_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserLoyaltyProgram_Id_seq" OWNED BY "UserLoyaltyProgram"."Id";


--
-- Name: UserReferral; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserReferral" (
    "Id" integer NOT NULL,
    "UserId" integer,
    "ReferrerUserId" integer NOT NULL,
    "EventId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: UserReferral_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserReferral_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserReferral_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserReferral_Id_seq" OWNED BY "UserReferral"."Id";


--
-- Name: UserSettings; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserSettings" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "HideFatherName" boolean DEFAULT false NOT NULL,
    "Incomplete" boolean DEFAULT false NOT NULL,
    "Agreement" boolean DEFAULT false NOT NULL,
    "Visible" boolean DEFAULT true NOT NULL,
    "IndexProfile" boolean DEFAULT true NOT NULL,
    "HideBirthdayYear" boolean DEFAULT false NOT NULL,
    "UnsubscribeAll" boolean DEFAULT false NOT NULL,
    "Unsubscribe" text[]
);


--
-- Name: UserSettings_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserSettings_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserSettings_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserSettings_Id_seq" OWNED BY "UserSettings"."Id";


--
-- Name: UserUnsubscribeEventMail; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "UserUnsubscribeEventMail" (
    "Id" integer NOT NULL,
    "UserId" integer NOT NULL,
    "EventId" integer NOT NULL,
    "CreationTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


--
-- Name: UserUnsubscribeEventMail_Id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "UserUnsubscribeEventMail_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: UserUnsubscribeEventMail_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "UserUnsubscribeEventMail_Id_seq" OWNED BY "UserUnsubscribeEventMail"."Id";


--
-- Name: User_RunetId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "User_RunetId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: User_RunetId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "User_RunetId_seq" OWNED BY "User"."RunetId";


--
-- Name: User_UserId_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "User_UserId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: User_UserId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "User_UserId_seq" OWNED BY "User"."Id";


--
-- Name: YiiSession; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "YiiSession" (
    id character(32) NOT NULL,
    expire integer,
    data bytea
);


--
-- Name: hibernate_sequence; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE hibernate_sequence
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_migration; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE tbl_migration (
    version character varying(255) NOT NULL,
    apply_time integer
);


--
-- Name: AdminGroup Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AdminGroup" ALTER COLUMN "Id" SET DEFAULT nextval('"AdminGroup_Id_seq"'::regclass);


--
-- Name: AdminGroupRole Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AdminGroupRole" ALTER COLUMN "Id" SET DEFAULT nextval('"AdminGroupRole_Id_seq"'::regclass);


--
-- Name: AdminGroupUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AdminGroupUser" ALTER COLUMN "Id" SET DEFAULT nextval('"AdminGroupUser_Id_seq"'::regclass);


--
-- Name: ApiAccount Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiAccount" ALTER COLUMN "Id" SET DEFAULT nextval('"ApiAccount_Id_seq"'::regclass);


--
-- Name: ApiCallbackLog Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiCallbackLog" ALTER COLUMN "Id" SET DEFAULT nextval('"ApiCallbackLog_Id_seq"'::regclass);


--
-- Name: ApiDomain Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiDomain" ALTER COLUMN "Id" SET DEFAULT nextval('"ApiDomain_Id_seq"'::regclass);


--
-- Name: ApiExternalUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiExternalUser" ALTER COLUMN "Id" SET DEFAULT nextval('"ApiExternalUser_Id_seq"'::regclass);


--
-- Name: ApiIP Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiIP" ALTER COLUMN "Id" SET DEFAULT nextval('"ApiIP_Id_seq"'::regclass);


--
-- Name: AttributeDefinition Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AttributeDefinition" ALTER COLUMN "Id" SET DEFAULT nextval('"AttributeDefinition_Id_seq"'::regclass);


--
-- Name: AttributeGroup Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AttributeGroup" ALTER COLUMN "Id" SET DEFAULT nextval('"AttributeGroup_Id_seq"'::regclass);


--
-- Name: CatalogCompany Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CatalogCompany" ALTER COLUMN "Id" SET DEFAULT nextval('"CatalogCompany_Id_seq"'::regclass);


--
-- Name: Commission Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Commission" ALTER COLUMN "Id" SET DEFAULT nextval('"Commission_Id_seq"'::regclass);


--
-- Name: CommissionProject Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CommissionProject" ALTER COLUMN "Id" SET DEFAULT nextval('"CommissionProject_Id_seq"'::regclass);


--
-- Name: CommissionProjectUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CommissionProjectUser" ALTER COLUMN "Id" SET DEFAULT nextval('"CommissionProjectUser_Id_seq"'::regclass);


--
-- Name: CommissionRole Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CommissionRole" ALTER COLUMN "Id" SET DEFAULT nextval('"CommissionRole_Id_seq"'::regclass);


--
-- Name: CommissionUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CommissionUser" ALTER COLUMN "Id" SET DEFAULT nextval('"CommissionUser_Id_seq"'::regclass);


--
-- Name: Company Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Company" ALTER COLUMN "Id" SET DEFAULT nextval('"Company_Id_seq"'::regclass);


--
-- Name: CompanyLinkAddress Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkAddress" ALTER COLUMN "Id" SET DEFAULT nextval('"CompanyLinkAddress_Id_seq"'::regclass);


--
-- Name: CompanyLinkEmail Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkEmail" ALTER COLUMN "Id" SET DEFAULT nextval('"CompanyLinkEmail_Id_seq"'::regclass);


--
-- Name: CompanyLinkModerator Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkModerator" ALTER COLUMN "Id" SET DEFAULT nextval('"CompanyLinkModerator_Id_seq"'::regclass);


--
-- Name: CompanyLinkPhone Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkPhone" ALTER COLUMN "Id" SET DEFAULT nextval('"CompanyLinkPhone_Id_seq"'::regclass);


--
-- Name: CompanyLinkSite Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkSite" ALTER COLUMN "Id" SET DEFAULT nextval('"CompanyLinkSite_Id_seq"'::regclass);


--
-- Name: CompetenceQuestionType Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompetenceQuestionType" ALTER COLUMN "Id" SET DEFAULT nextval('"CompetenceQuestionType_Id_seq"'::regclass);


--
-- Name: CompetenceResult Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompetenceResult" ALTER COLUMN "Id" SET DEFAULT nextval('"CompetenceResult_Id_seq"'::regclass);


--
-- Name: CompetenceTest Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompetenceTest" ALTER COLUMN "Id" SET DEFAULT nextval('"CompetenceTest_Id_seq"'::regclass);


--
-- Name: ConnectMeeting Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ConnectMeeting" ALTER COLUMN "Id" SET DEFAULT nextval('"ConnectMeeting_Id_seq"'::regclass);


--
-- Name: ConnectMeetingLinkUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ConnectMeetingLinkUser" ALTER COLUMN "Id" SET DEFAULT nextval('"ConnectMeetingLinkUser_Id_seq"'::regclass);


--
-- Name: ContactAddress Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactAddress" ALTER COLUMN "Id" SET DEFAULT nextval('"ContactAddress_Id_seq"'::regclass);


--
-- Name: ContactEmail Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactEmail" ALTER COLUMN "Id" SET DEFAULT nextval('"ContactEmail_Id_seq"'::regclass);


--
-- Name: ContactPhone Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactPhone" ALTER COLUMN "Id" SET DEFAULT nextval('"ContactPhone_Id_seq"'::regclass);


--
-- Name: ContactServiceAccount Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactServiceAccount" ALTER COLUMN "Id" SET DEFAULT nextval('"ContactServiceAccount_Id_seq"'::regclass);


--
-- Name: ContactServiceType Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactServiceType" ALTER COLUMN "Id" SET DEFAULT nextval('"ContactServiceType_Id_seq"'::regclass);


--
-- Name: ContactSite Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactSite" ALTER COLUMN "Id" SET DEFAULT nextval('"ContactSite_Id_seq"'::regclass);


--
-- Name: EducationFaculty Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EducationFaculty" ALTER COLUMN "Id" SET DEFAULT nextval('"EducationFaculty_Id_seq"'::regclass);


--
-- Name: EducationUniversity Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EducationUniversity" ALTER COLUMN "Id" SET DEFAULT nextval('"EducationUniversity_Id_seq"'::regclass);


--
-- Name: Event Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Event" ALTER COLUMN "Id" SET DEFAULT nextval('"Event_EventId_seq"'::regclass);


--
-- Name: EventAttribute Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventAttribute" ALTER COLUMN "Id" SET DEFAULT nextval('"EventAttribute_Id_seq"'::regclass);


--
-- Name: EventInvite Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventInvite" ALTER COLUMN "Id" SET DEFAULT nextval('"EventInvite_Id_seq"'::regclass);


--
-- Name: EventInviteRequest Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventInviteRequest" ALTER COLUMN "Id" SET DEFAULT nextval('"EventInviteRequest_Id_seq"'::regclass);


--
-- Name: EventLinkAddress Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkAddress" ALTER COLUMN "Id" SET DEFAULT nextval('"EventLinkAddress_Id_seq"'::regclass);


--
-- Name: EventLinkEmail Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkEmail" ALTER COLUMN "Id" SET DEFAULT nextval('"EventLinkEmail_Id_seq"'::regclass);


--
-- Name: EventLinkPhone Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkPhone" ALTER COLUMN "Id" SET DEFAULT nextval('"EventLinkPhone_Id_seq"'::regclass);


--
-- Name: EventLinkProfessionalInterest Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkProfessionalInterest" ALTER COLUMN "Id" SET DEFAULT nextval('"EventLinkProfessionalInterest_Id_seq"'::regclass);


--
-- Name: EventLinkPurpose Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkPurpose" ALTER COLUMN "Id" SET DEFAULT nextval('"EventLinkPurpose_Id_seq"'::regclass);


--
-- Name: EventLinkRole Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkRole" ALTER COLUMN "Id" SET DEFAULT nextval('"EventLinkRole_Id_seq"'::regclass);


--
-- Name: EventLinkSite Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkSite" ALTER COLUMN "Id" SET DEFAULT nextval('"EventLinkSite_Id_seq"'::regclass);


--
-- Name: EventLinkTag Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkTag" ALTER COLUMN "Id" SET DEFAULT nextval('"EventLinkTag_Id_seq"'::regclass);


--
-- Name: EventLinkWidget Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkWidget" ALTER COLUMN "Id" SET DEFAULT nextval('"EventWidget_Id_seq"'::regclass);


--
-- Name: EventMeetingPlace Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventMeetingPlace" ALTER COLUMN "Id" SET DEFAULT nextval('"EventMeetingPlace_Id_seq"'::regclass);


--
-- Name: EventPart Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventPart" ALTER COLUMN "Id" SET DEFAULT nextval('"EventPart_Id_seq"'::regclass);


--
-- Name: EventParticipant Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventParticipant" ALTER COLUMN "Id" SET DEFAULT nextval('"EventParticipant_Id_seq"'::regclass);


--
-- Name: EventParticipantLog Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventParticipantLog" ALTER COLUMN "Id" SET DEFAULT nextval('"EventParticipantLog_Id_seq"'::regclass);


--
-- Name: EventPartner Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventPartner" ALTER COLUMN "Id" SET DEFAULT nextval('"EventPartner_Id_seq"'::regclass);


--
-- Name: EventPartnerType Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventPartnerType" ALTER COLUMN "Id" SET DEFAULT nextval('"EventPartnerType_Id_seq"'::regclass);


--
-- Name: EventPurpose Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventPurpose" ALTER COLUMN "Id" SET DEFAULT nextval('"EventPurpose_Id_seq"'::regclass);


--
-- Name: EventPurposeLink Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventPurposeLink" ALTER COLUMN "Id" SET DEFAULT nextval('"EventPurposeLink_Id_seq"'::regclass);


--
-- Name: EventRole Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventRole" ALTER COLUMN "Id" SET DEFAULT nextval('"EventRole_Id_seq"'::regclass);


--
-- Name: EventSection Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSection" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSection_Id_seq"'::regclass);


--
-- Name: EventSectionAttribute Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionAttribute" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionAttribute_Id_seq"'::regclass);


--
-- Name: EventSectionFavorite Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionFavorite" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionFavorite_Id_seq"'::regclass);


--
-- Name: EventSectionHall Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionHall" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionHall_Id_seq"'::regclass);


--
-- Name: EventSectionLinkHall Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionLinkHall" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionLinkHall_Id_seq"'::regclass);


--
-- Name: EventSectionLinkTheme Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionLinkTheme" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionLinkTheme_Id_seq"'::regclass);


--
-- Name: EventSectionLinkUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionLinkUser" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionLinkUser_Id_seq"'::regclass);


--
-- Name: EventSectionPartner Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionPartner" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionPartner_Id_seq"'::regclass);


--
-- Name: EventSectionReport Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionReport" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionReport_Id_seq"'::regclass);


--
-- Name: EventSectionRole Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionRole" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionRole_Id_seq"'::regclass);


--
-- Name: EventSectionTheme Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionTheme" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionTheme_Id_seq"'::regclass);


--
-- Name: EventSectionType Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionType" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionType_Id_seq"'::regclass);


--
-- Name: EventSectionUserVisit Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionUserVisit" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionUserVisit_Id_seq"'::regclass);


--
-- Name: EventSectionVote Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionVote" ALTER COLUMN "Id" SET DEFAULT nextval('"EventSectionVote_Id_seq"'::regclass);


--
-- Name: EventType Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventType" ALTER COLUMN "Id" SET DEFAULT nextval('"EventType_Id_seq"'::regclass);


--
-- Name: EventUserAdditionalAttribute Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventUserAdditionalAttribute" ALTER COLUMN "Id" SET DEFAULT nextval('"EventUserAdditionalAttribute_Id_seq"'::regclass);


--
-- Name: EventUserData Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventUserData" ALTER COLUMN "Id" SET DEFAULT nextval('"EventUserData_Id_seq"'::regclass);


--
-- Name: EventWidgetClass Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventWidgetClass" ALTER COLUMN "Id" SET DEFAULT nextval('"EventWidgetClass_Id_seq"'::regclass);


--
-- Name: GeoCity Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "GeoCity" ALTER COLUMN "Id" SET DEFAULT nextval('"Geo2City_Id_seq"'::regclass);


--
-- Name: GeoCountry Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "GeoCountry" ALTER COLUMN "Id" SET DEFAULT nextval('"Geo2Country_Id_seq"'::regclass);


--
-- Name: GeoRegion Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "GeoRegion" ALTER COLUMN "Id" SET DEFAULT nextval('"Geo2Region_Id_seq"'::regclass);


--
-- Name: IctRole Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IctRole" ALTER COLUMN "Id" SET DEFAULT nextval('"IctRole_Id_seq"'::regclass);


--
-- Name: IctUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IctUser" ALTER COLUMN "Id" SET DEFAULT nextval('"IctUser_Id_seq"'::regclass);


--
-- Name: IriRole Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IriRole" ALTER COLUMN "Id" SET DEFAULT nextval('"IriRole_Id_seq"'::regclass);


--
-- Name: IriUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IriUser" ALTER COLUMN "Id" SET DEFAULT nextval('"IriUser_Id_seq"'::regclass);


--
-- Name: Job Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Job" ALTER COLUMN "Id" SET DEFAULT nextval('"Jobs_Id_seq"'::regclass);


--
-- Name: JobCategory Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "JobCategory" ALTER COLUMN "Id" SET DEFAULT nextval('"JobCategory_Id_seq"'::regclass);


--
-- Name: JobCompany Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "JobCompany" ALTER COLUMN "Id" SET DEFAULT nextval('"JobCompany_Id_seq"'::regclass);


--
-- Name: JobPosition Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "JobPosition" ALTER COLUMN "Id" SET DEFAULT nextval('"JobPosition_Id_seq"'::regclass);


--
-- Name: JobUp Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "JobUp" ALTER COLUMN "Id" SET DEFAULT nextval('"JobUp_Id_seq"'::regclass);


--
-- Name: Link Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Link" ALTER COLUMN "Id" SET DEFAULT nextval('"Link_Id_seq"'::regclass);


--
-- Name: MailLog Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "MailLog" ALTER COLUMN "Id" SET DEFAULT nextval('"MailLog_Id_seq"'::regclass);


--
-- Name: MailTemplate Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "MailTemplate" ALTER COLUMN "Id" SET DEFAULT nextval('"MailTemplate_Id_seq"'::regclass);


--
-- Name: News Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "News" ALTER COLUMN "Id" SET DEFAULT nextval('"News_Id_seq"'::regclass);


--
-- Name: OAuthAccessToken Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OAuthAccessToken" ALTER COLUMN "Id" SET DEFAULT nextval('"OAuthAccessToken_Id_seq"'::regclass);


--
-- Name: OAuthPermission Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OAuthPermission" ALTER COLUMN "Id" SET DEFAULT nextval('"OAuthPermission_Id_seq"'::regclass);


--
-- Name: OAuthSocial Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OAuthSocial" ALTER COLUMN "Id" SET DEFAULT nextval('"OAuthSocial_Id_seq"'::regclass);


--
-- Name: PaperlessDevice Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDevice" ALTER COLUMN "Id" SET DEFAULT nextval('"PaperlessDevice_Id_seq"'::regclass);


--
-- Name: PaperlessDevice EventId; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDevice" ALTER COLUMN "EventId" SET DEFAULT nextval('"PaperlessDevice_EventId_seq"'::regclass);


--
-- Name: PaperlessDevice DeviceNumber; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDevice" ALTER COLUMN "DeviceNumber" SET DEFAULT nextval('"PaperlessDevice_DeviceId_seq"'::regclass);


--
-- Name: PaperlessDeviceSignal Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDeviceSignal" ALTER COLUMN "Id" SET DEFAULT nextval('"PaperlessDeviceSignal_Id_seq"'::regclass);


--
-- Name: PaperlessDeviceSignal EventId; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDeviceSignal" ALTER COLUMN "EventId" SET DEFAULT nextval('"PaperlessDeviceSignal_EventId_seq"'::regclass);


--
-- Name: PaperlessDeviceSignal DeviceNumber; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDeviceSignal" ALTER COLUMN "DeviceNumber" SET DEFAULT nextval('"PaperlessDeviceSignal_DeviceId_seq"'::regclass);


--
-- Name: PaperlessDeviceSignal BadgeUID; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDeviceSignal" ALTER COLUMN "BadgeUID" SET DEFAULT nextval('"PaperlessDeviceSignal_BadgeId_seq"'::regclass);


--
-- Name: PaperlessEvent Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEvent" ALTER COLUMN "Id" SET DEFAULT nextval('"PaperlessEvent_Id_seq"'::regclass);


--
-- Name: PaperlessEventLinkDevice Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkDevice" ALTER COLUMN "Id" SET DEFAULT nextval('"PaperlessEventLinkDevice_Id_seq"'::regclass);


--
-- Name: PaperlessEventLinkDevice DeviceId; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkDevice" ALTER COLUMN "DeviceId" SET DEFAULT nextval('"PaperlessEventLinkDevice_DeviceId_seq"'::regclass);


--
-- Name: PaperlessEventLinkMaterial Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkMaterial" ALTER COLUMN "Id" SET DEFAULT nextval('"PaperlessEventLinkMaterial_Id_seq"'::regclass);


--
-- Name: PaperlessEventLinkMaterial EventId; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkMaterial" ALTER COLUMN "EventId" SET DEFAULT nextval('"PaperlessEventLinkMaterial_EventId_seq"'::regclass);


--
-- Name: PaperlessEventLinkMaterial MaterialId; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkMaterial" ALTER COLUMN "MaterialId" SET DEFAULT nextval('"PaperlessEventLinkMaterial_MaterialId_seq"'::regclass);


--
-- Name: PaperlessEventLinkRole Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkRole" ALTER COLUMN "Id" SET DEFAULT nextval('"PaperlessEventLinkRole_Id_seq"'::regclass);


--
-- Name: PaperlessMaterial Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterial" ALTER COLUMN "Id" SET DEFAULT nextval('"PaperlessMaterial_Id_seq"'::regclass);


--
-- Name: PaperlessMaterialLinkRole Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterialLinkRole" ALTER COLUMN "Id" SET DEFAULT nextval('"PaperlessMaterialLinkRole_Id_seq"'::regclass);


--
-- Name: PaperlessMaterialLinkUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterialLinkUser" ALTER COLUMN "Id" SET DEFAULT nextval('"PaperlessMaterialLinkUser_Id_seq"'::regclass);


--
-- Name: PaperlessMaterialLinkUser MaterialId; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterialLinkUser" ALTER COLUMN "MaterialId" SET DEFAULT nextval('"PaperlessMaterialLinkUser_MaterialId_seq"'::regclass);


--
-- Name: PaperlessMaterialLinkUser UserId; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterialLinkUser" ALTER COLUMN "UserId" SET DEFAULT nextval('"PaperlessMaterialLinkUser_UserId_seq"'::regclass);


--
-- Name: PartnerAccount Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerAccount" ALTER COLUMN "Id" SET DEFAULT nextval('"PartnerAccount_Id_seq"'::regclass);


--
-- Name: PartnerCallback Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerCallback" ALTER COLUMN "Id" SET DEFAULT nextval('"PartnerCallback_Id_seq"'::regclass);


--
-- Name: PartnerCallbackUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerCallbackUser" ALTER COLUMN "Id" SET DEFAULT nextval('"PartnerCallbackUser_Id_seq"'::regclass);


--
-- Name: PartnerExport Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerExport" ALTER COLUMN "Id" SET DEFAULT nextval('"PartnerExport_Id_seq"'::regclass);


--
-- Name: PartnerImport Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerImport" ALTER COLUMN "Id" SET DEFAULT nextval('"PartnerImport_Id_seq"'::regclass);


--
-- Name: PartnerImportUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerImportUser" ALTER COLUMN "Id" SET DEFAULT nextval('"PartnerImportUser_Id_seq"'::regclass);


--
-- Name: PayAccount Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayAccount" ALTER COLUMN "Id" SET DEFAULT nextval('"PayAccount_Id_seq"'::regclass);


--
-- Name: PayCollectionCoupon Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCollectionCoupon" ALTER COLUMN "Id" SET DEFAULT nextval('"PayCollectionCoupon_Id_seq"'::regclass);


--
-- Name: PayCollectionCouponAttribute Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCollectionCouponAttribute" ALTER COLUMN "Id" SET DEFAULT nextval('"PayCollectionCouponAttribute_Id_seq"'::regclass);


--
-- Name: PayCoupon Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCoupon" ALTER COLUMN "Id" SET DEFAULT nextval('"PayCoupon_Id_seq"'::regclass);


--
-- Name: PayCouponActivation Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCouponActivation" ALTER COLUMN "Id" SET DEFAULT nextval('"PayCouponActivated_Id_seq"'::regclass);


--
-- Name: PayCouponActivationLinkOrderItem Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCouponActivationLinkOrderItem" ALTER COLUMN "Id" SET DEFAULT nextval('"PayCouponActivationLinkOrderItem_Id_seq"'::regclass);


--
-- Name: PayFoodPartnerOrder Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayFoodPartnerOrder" ALTER COLUMN "Id" SET DEFAULT nextval('"PayFoodPartnerOrder_Id_seq"'::regclass);


--
-- Name: PayFoodPartnerOrderItem Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayFoodPartnerOrderItem" ALTER COLUMN "Id" SET DEFAULT nextval('"PayFoodPartnerOrderItem_Id_seq"'::regclass);


--
-- Name: PayLog Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayLog" ALTER COLUMN "Id" SET DEFAULT nextval('"PayLog_Id_seq"'::regclass);


--
-- Name: PayLoyaltyProgramDiscount Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayLoyaltyProgramDiscount" ALTER COLUMN "Id" SET DEFAULT nextval('"PayLoayaltyProgram_Id_seq"'::regclass);


--
-- Name: PayOrder Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrder" ALTER COLUMN "Id" SET DEFAULT nextval('"PayOrder_Id_seq"'::regclass);


--
-- Name: PayOrderImport Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderImport" ALTER COLUMN "Id" SET DEFAULT nextval('"PayOrderImport_Id_seq"'::regclass);


--
-- Name: PayOrderImportEntry Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderImportEntry" ALTER COLUMN "Id" SET DEFAULT nextval('"PayOrderImportOrder_Id_seq"'::regclass);


--
-- Name: PayOrderImportOrder Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderImportOrder" ALTER COLUMN "Id" SET DEFAULT nextval('"PayOrderImportOrder_Id_seq1"'::regclass);


--
-- Name: PayOrderItem Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderItem" ALTER COLUMN "Id" SET DEFAULT nextval('"PayOrderItem_Id_seq"'::regclass);


--
-- Name: PayOrderItemAttribute Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderItemAttribute" ALTER COLUMN "Id" SET DEFAULT nextval('"PayOrderItemAttribute_Id_seq"'::regclass);


--
-- Name: PayOrderJuridical Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderJuridical" ALTER COLUMN "Id" SET DEFAULT nextval('"PayOrderJuridical_Id_seq"'::regclass);


--
-- Name: PayOrderJuridicalTemplate Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderJuridicalTemplate" ALTER COLUMN "Id" SET DEFAULT nextval('"PayOrderJuridicalTemplate_Id_seq"'::regclass);


--
-- Name: PayOrderLinkOrderItem Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderLinkOrderItem" ALTER COLUMN "Id" SET DEFAULT nextval('"PayOrderLinkOrderItem_Id_seq"'::regclass);


--
-- Name: PayProduct Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProduct" ALTER COLUMN "Id" SET DEFAULT nextval('"PayProduct_Id_seq"'::regclass);


--
-- Name: PayProductAttribute Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProductAttribute" ALTER COLUMN "Id" SET DEFAULT nextval('"PayProductAttribute_Id_seq"'::regclass);


--
-- Name: PayProductCheck Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProductCheck" ALTER COLUMN "Id" SET DEFAULT nextval('"PayProductGet_Id_seq"'::regclass);


--
-- Name: PayProductPrice Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProductPrice" ALTER COLUMN "Id" SET DEFAULT nextval('"PayProductPrice_Id_seq"'::regclass);


--
-- Name: PayProductUserAccess Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProductUserAccess" ALTER COLUMN "Id" SET DEFAULT nextval('"PayProductUserAccess_Id_seq"'::regclass);


--
-- Name: PayReferralDiscount Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayReferralDiscount" ALTER COLUMN "Id" SET DEFAULT nextval('"PayReferralDiscount_Id_seq"'::regclass);


--
-- Name: PayRoomPartnerBooking Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayRoomPartnerBooking" ALTER COLUMN "Id" SET DEFAULT nextval('"PayRoomPartnerBooking_Id_seq"'::regclass);


--
-- Name: PayRoomPartnerOrder Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayRoomPartnerOrder" ALTER COLUMN "Id" SET DEFAULT nextval('"PayRoomPartnerOrder_Id_seq"'::regclass);


--
-- Name: ProfessionalInterest Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ProfessionalInterest" ALTER COLUMN "Id" SET DEFAULT nextval('"ProfessionalInterest_Id_seq"'::regclass);


--
-- Name: RaecBrief Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecBrief" ALTER COLUMN "Id" SET DEFAULT nextval('"RaecBrief_Id_seq"'::regclass);


--
-- Name: RaecBriefLinkCompany Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecBriefLinkCompany" ALTER COLUMN "Id" SET DEFAULT nextval('"RaecBriefCompany_Id_seq"'::regclass);


--
-- Name: RaecBriefLinkUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecBriefLinkUser" ALTER COLUMN "Id" SET DEFAULT nextval('"RaecBriefLinkUser_Id_seq"'::regclass);


--
-- Name: RaecBriefUserRole Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecBriefUserRole" ALTER COLUMN "Id" SET DEFAULT nextval('"RaecBriefUserRole_Id_seq"'::regclass);


--
-- Name: RaecCompanyUser Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecCompanyUser" ALTER COLUMN "Id" SET DEFAULT nextval('"RaecCompanyUser_Id_seq"'::regclass);


--
-- Name: RaecCompanyUserStatus Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecCompanyUserStatus" ALTER COLUMN "Id" SET DEFAULT nextval('"RaecCompanyUserStatus_Id_seq"'::regclass);


--
-- Name: RuventsAccount Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsAccount" ALTER COLUMN "Id" SET DEFAULT nextval('"RuventsAccount_Id_seq"'::regclass);


--
-- Name: RuventsBadge Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsBadge" ALTER COLUMN "Id" SET DEFAULT nextval('"RuventsBadge_Id_seq"'::regclass);


--
-- Name: RuventsDetailLog Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsDetailLog" ALTER COLUMN "Id" SET DEFAULT nextval('"RuventsDetailLog_Id_seq"'::regclass);


--
-- Name: RuventsOperator Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsOperator" ALTER COLUMN "Id" SET DEFAULT nextval('"RuventsOperator_Id_seq"'::regclass);


--
-- Name: RuventsSetting Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsSetting" ALTER COLUMN "Id" SET DEFAULT nextval('"RuventsSetting_Id_seq"'::regclass);


--
-- Name: RuventsVisit Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsVisit" ALTER COLUMN "Id" SET DEFAULT nextval('"RuventsVisit_Id_seq"'::regclass);


--
-- Name: ShortUrl Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ShortUrl" ALTER COLUMN "Id" SET DEFAULT nextval('"ShortUrl_Id_seq1"'::regclass);


--
-- Name: Tag Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Tag" ALTER COLUMN "Id" SET DEFAULT nextval('"Tag_Id_seq"'::regclass);


--
-- Name: TmpRifParking Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "TmpRifParking" ALTER COLUMN "Id" SET DEFAULT nextval('"TmpRifParking_Id_seq"'::regclass);


--
-- Name: Translation Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Translation" ALTER COLUMN "Id" SET DEFAULT nextval('"Translation_Id_seq"'::regclass);


--
-- Name: User Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "User" ALTER COLUMN "Id" SET DEFAULT nextval('"User_UserId_seq"'::regclass);


--
-- Name: User RunetId; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "User" ALTER COLUMN "RunetId" SET DEFAULT nextval('"User_RunetId_seq"'::regclass);


--
-- Name: UserDevice Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserDevice" ALTER COLUMN "Id" SET DEFAULT nextval('"UserDevice_Id_seq"'::regclass);


--
-- Name: UserDocument Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserDocument" ALTER COLUMN "Id" SET DEFAULT nextval('"UserDocument_Id_seq"'::regclass);


--
-- Name: UserDocumentType Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserDocumentType" ALTER COLUMN "Id" SET DEFAULT nextval('"UserDocumentType_Id_seq"'::regclass);


--
-- Name: UserEducation Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserEducation" ALTER COLUMN "Id" SET DEFAULT nextval('"UserEducation_Id_seq"'::regclass);


--
-- Name: UserEmployment Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserEmployment" ALTER COLUMN "Id" SET DEFAULT nextval('"UserEmployment_Id_seq"'::regclass);


--
-- Name: UserLinkAddress Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkAddress" ALTER COLUMN "Id" SET DEFAULT nextval('"UserLinkAddress_Id_seq"'::regclass);


--
-- Name: UserLinkEmail Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkEmail" ALTER COLUMN "Id" SET DEFAULT nextval('"UserLinkEmail_Id_seq"'::regclass);


--
-- Name: UserLinkPhone Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkPhone" ALTER COLUMN "Id" SET DEFAULT nextval('"UserLinkPhone_Id_seq"'::regclass);


--
-- Name: UserLinkProfessionalInterest Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkProfessionalInterest" ALTER COLUMN "Id" SET DEFAULT nextval('"UserLinkProfessionalInterest_Id_seq"'::regclass);


--
-- Name: UserLinkServiceAccount Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkServiceAccount" ALTER COLUMN "Id" SET DEFAULT nextval('"UserLinkServiceAccount_Id_seq"'::regclass);


--
-- Name: UserLinkSite Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkSite" ALTER COLUMN "Id" SET DEFAULT nextval('"UserLinkSite_Id_seq"'::regclass);


--
-- Name: UserLoyaltyProgram Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLoyaltyProgram" ALTER COLUMN "Id" SET DEFAULT nextval('"UserLoyaltyProgram_Id_seq"'::regclass);


--
-- Name: UserReferral Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserReferral" ALTER COLUMN "Id" SET DEFAULT nextval('"UserReferral_Id_seq"'::regclass);


--
-- Name: UserSettings Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserSettings" ALTER COLUMN "Id" SET DEFAULT nextval('"UserSettings_Id_seq"'::regclass);


--
-- Name: UserUnsubscribeEventMail Id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserUnsubscribeEventMail" ALTER COLUMN "Id" SET DEFAULT nextval('"UserUnsubscribeEventMail_Id_seq"'::regclass);


--
-- Name: AdminGroupRole AdminGroupRole_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AdminGroupRole"
    ADD CONSTRAINT "AdminGroupRole_pkey" PRIMARY KEY ("Id");


--
-- Name: AdminGroupUser AdminGroupUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AdminGroupUser"
    ADD CONSTRAINT "AdminGroupUser_pkey" PRIMARY KEY ("Id");


--
-- Name: AdminGroup AdminGroup_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AdminGroup"
    ADD CONSTRAINT "AdminGroup_pkey" PRIMARY KEY ("Id");


--
-- Name: ApiAccountQuotaByUserLog ApiAccountQuotaByUserLog_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiAccountQuotaByUserLog"
    ADD CONSTRAINT "ApiAccountQuotaByUserLog_pkey" PRIMARY KEY ("AccountId", "UserId");


--
-- Name: ApiAccount ApiAccount_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiAccount"
    ADD CONSTRAINT "ApiAccount_pkey" PRIMARY KEY ("Id");


--
-- Name: ApiCallbackLog ApiCallbackLog_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiCallbackLog"
    ADD CONSTRAINT "ApiCallbackLog_pkey" PRIMARY KEY ("Id");


--
-- Name: ApiDomain ApiDomain_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiDomain"
    ADD CONSTRAINT "ApiDomain_pkey" PRIMARY KEY ("Id");


--
-- Name: ApiExternalUser ApiExternalUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiExternalUser"
    ADD CONSTRAINT "ApiExternalUser_pkey" PRIMARY KEY ("Id");


--
-- Name: ApiIP ApiIP_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiIP"
    ADD CONSTRAINT "ApiIP_pkey" PRIMARY KEY ("Id");


--
-- Name: AttributeDefinition AttributeDefinition_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AttributeDefinition"
    ADD CONSTRAINT "AttributeDefinition_pkey" PRIMARY KEY ("Id");


--
-- Name: AttributeGroup AttributeGroup_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AttributeGroup"
    ADD CONSTRAINT "AttributeGroup_pkey" PRIMARY KEY ("Id");


--
-- Name: BuduGuruCourse BuduGuruCourse_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "BuduGuruCourse"
    ADD CONSTRAINT "BuduGuruCourse_pkey" PRIMARY KEY ("Id");


--
-- Name: CatalogCompany CatalogCompany_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CatalogCompany"
    ADD CONSTRAINT "CatalogCompany_pkey" PRIMARY KEY ("Id");


--
-- Name: CommissionProjectUser CommissionProjectUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CommissionProjectUser"
    ADD CONSTRAINT "CommissionProjectUser_pkey" PRIMARY KEY ("Id");


--
-- Name: CommissionProject CommissionProject_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CommissionProject"
    ADD CONSTRAINT "CommissionProject_pkey" PRIMARY KEY ("Id");


--
-- Name: CommissionRole CommissionRole_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CommissionRole"
    ADD CONSTRAINT "CommissionRole_pkey" PRIMARY KEY ("Id");


--
-- Name: CommissionUser CommissionUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CommissionUser"
    ADD CONSTRAINT "CommissionUser_pkey" PRIMARY KEY ("Id");


--
-- Name: Commission Commission_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Commission"
    ADD CONSTRAINT "Commission_pkey" PRIMARY KEY ("Id");


--
-- Name: CompanyLinkAddress CompanyLinkAddress_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkAddress"
    ADD CONSTRAINT "CompanyLinkAddress_pkey" PRIMARY KEY ("Id");


--
-- Name: CompanyLinkCommission CompanyLinkCommission_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkCommission"
    ADD CONSTRAINT "CompanyLinkCommission_pkey" PRIMARY KEY ("CompanyId", "CommissionId");


--
-- Name: CompanyLinkEmail CompanyLinkEmail_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkEmail"
    ADD CONSTRAINT "CompanyLinkEmail_pkey" PRIMARY KEY ("Id");


--
-- Name: CompanyLinkModerator CompanyLinkModerator_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkModerator"
    ADD CONSTRAINT "CompanyLinkModerator_pkey" PRIMARY KEY ("Id");


--
-- Name: CompanyLinkPhone CompanyLinkPhone_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkPhone"
    ADD CONSTRAINT "CompanyLinkPhone_pkey" PRIMARY KEY ("Id");


--
-- Name: CompanyLinkProfessionalInterest CompanyLinkProfessionalInterest_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkProfessionalInterest"
    ADD CONSTRAINT "CompanyLinkProfessionalInterest_pkey" PRIMARY KEY ("CompanyId", "ProfessionalInterestId");


--
-- Name: CompanyLinkSite CompanyLinkSite_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkSite"
    ADD CONSTRAINT "CompanyLinkSite_pkey" PRIMARY KEY ("Id");


--
-- Name: Company Company_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Company"
    ADD CONSTRAINT "Company_pkey" PRIMARY KEY ("Id");


--
-- Name: CompetenceQuestionType CompetenceQuestionType_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompetenceQuestionType"
    ADD CONSTRAINT "CompetenceQuestionType_pkey" PRIMARY KEY ("Id");


--
-- Name: CompetenceQuestion CompetenceQuestion_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompetenceQuestion"
    ADD CONSTRAINT "CompetenceQuestion_pkey" PRIMARY KEY ("Id");


--
-- Name: CompetenceResult CompetenceResult_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompetenceResult"
    ADD CONSTRAINT "CompetenceResult_pkey" PRIMARY KEY ("Id");


--
-- Name: CompetenceTest CompetenceTest_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompetenceTest"
    ADD CONSTRAINT "CompetenceTest_pkey" PRIMARY KEY ("Id");


--
-- Name: ConnectMeetingLinkUser ConnectMeetingLinkUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ConnectMeetingLinkUser"
    ADD CONSTRAINT "ConnectMeetingLinkUser_pkey" PRIMARY KEY ("Id");


--
-- Name: ConnectMeeting ConnectMeeting_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ConnectMeeting"
    ADD CONSTRAINT "ConnectMeeting_pkey" PRIMARY KEY ("Id");


--
-- Name: ContactAddress ContactAddress_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactAddress"
    ADD CONSTRAINT "ContactAddress_pkey" PRIMARY KEY ("Id");


--
-- Name: ContactEmail ContactEmail_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactEmail"
    ADD CONSTRAINT "ContactEmail_pkey" PRIMARY KEY ("Id");


--
-- Name: ContactPhone ContactPhone_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactPhone"
    ADD CONSTRAINT "ContactPhone_pkey" PRIMARY KEY ("Id");


--
-- Name: ContactServiceAccount ContactServiceAccount_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactServiceAccount"
    ADD CONSTRAINT "ContactServiceAccount_pkey" PRIMARY KEY ("Id");


--
-- Name: ContactServiceType ContactServiceType_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactServiceType"
    ADD CONSTRAINT "ContactServiceType_pkey" PRIMARY KEY ("Id");


--
-- Name: ContactSite ContactSite_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactSite"
    ADD CONSTRAINT "ContactSite_pkey" PRIMARY KEY ("Id");


--
-- Name: EducationFaculty EducationFaculty_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EducationFaculty"
    ADD CONSTRAINT "EducationFaculty_pkey" PRIMARY KEY ("Id");


--
-- Name: EducationUniversity EducationUniversity_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EducationUniversity"
    ADD CONSTRAINT "EducationUniversity_pkey" PRIMARY KEY ("Id");


--
-- Name: EventAttribute EventAttribute_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventAttribute"
    ADD CONSTRAINT "EventAttribute_pkey" PRIMARY KEY ("Id");


--
-- Name: EventInviteRequest EventInviteRequest_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventInviteRequest"
    ADD CONSTRAINT "EventInviteRequest_pkey" PRIMARY KEY ("Id");


--
-- Name: EventInvite EventInvite_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventInvite"
    ADD CONSTRAINT "EventInvite_pkey" PRIMARY KEY ("Id");


--
-- Name: EventLinkAddress EventLinkAddress_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkAddress"
    ADD CONSTRAINT "EventLinkAddress_pkey" PRIMARY KEY ("Id");


--
-- Name: EventLinkEmail EventLinkEmail_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkEmail"
    ADD CONSTRAINT "EventLinkEmail_pkey" PRIMARY KEY ("Id");


--
-- Name: EventLinkPhone EventLinkPhone_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkPhone"
    ADD CONSTRAINT "EventLinkPhone_pkey" PRIMARY KEY ("Id");


--
-- Name: EventLinkProfessionalInterest EventLinkProfessionalInterest_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkProfessionalInterest"
    ADD CONSTRAINT "EventLinkProfessionalInterest_pkey" PRIMARY KEY ("Id");


--
-- Name: EventLinkPurpose EventLinkPurpose_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkPurpose"
    ADD CONSTRAINT "EventLinkPurpose_pkey" PRIMARY KEY ("Id");


--
-- Name: EventLinkRole EventLinkRole_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkRole"
    ADD CONSTRAINT "EventLinkRole_pkey" PRIMARY KEY ("Id");


--
-- Name: EventLinkSite EventLinkSite_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkSite"
    ADD CONSTRAINT "EventLinkSite_pkey" PRIMARY KEY ("Id");


--
-- Name: EventLinkTag EventLinkTag_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkTag"
    ADD CONSTRAINT "EventLinkTag_pkey" PRIMARY KEY ("Id");


--
-- Name: EventMeetingPlace EventMeetingPlace_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventMeetingPlace"
    ADD CONSTRAINT "EventMeetingPlace_pkey" PRIMARY KEY ("Id");


--
-- Name: EventPart EventPart_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventPart"
    ADD CONSTRAINT "EventPart_pkey" PRIMARY KEY ("Id");


--
-- Name: EventParticipantLog EventParticipantLog_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventParticipantLog"
    ADD CONSTRAINT "EventParticipantLog_pkey" PRIMARY KEY ("Id");


--
-- Name: EventParticipant EventParticipant_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventParticipant"
    ADD CONSTRAINT "EventParticipant_pkey" PRIMARY KEY ("Id");


--
-- Name: EventPartnerType EventPartnerType_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventPartnerType"
    ADD CONSTRAINT "EventPartnerType_pkey" PRIMARY KEY ("Id");


--
-- Name: EventPartner EventPartner_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventPartner"
    ADD CONSTRAINT "EventPartner_pkey" PRIMARY KEY ("Id");


--
-- Name: EventPurposeLink EventPurposeLink_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventPurposeLink"
    ADD CONSTRAINT "EventPurposeLink_pkey" PRIMARY KEY ("Id");


--
-- Name: EventPurpose EventPurpose_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventPurpose"
    ADD CONSTRAINT "EventPurpose_pkey" PRIMARY KEY ("Id");


--
-- Name: EventRole EventRole_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventRole"
    ADD CONSTRAINT "EventRole_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionAttribute EventSectionAttribute_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionAttribute"
    ADD CONSTRAINT "EventSectionAttribute_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionFavorite EventSectionFavorite_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionFavorite"
    ADD CONSTRAINT "EventSectionFavorite_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionHall EventSectionHall_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionHall"
    ADD CONSTRAINT "EventSectionHall_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionLinkHall EventSectionLinkHall_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionLinkHall"
    ADD CONSTRAINT "EventSectionLinkHall_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionLinkTheme EventSectionLinkTheme_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionLinkTheme"
    ADD CONSTRAINT "EventSectionLinkTheme_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionLinkUser EventSectionLinkUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionLinkUser"
    ADD CONSTRAINT "EventSectionLinkUser_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionPartner EventSectionPartner_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionPartner"
    ADD CONSTRAINT "EventSectionPartner_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionReport EventSectionReport_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionReport"
    ADD CONSTRAINT "EventSectionReport_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionRole EventSectionRole_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionRole"
    ADD CONSTRAINT "EventSectionRole_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionTheme EventSectionTheme_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionTheme"
    ADD CONSTRAINT "EventSectionTheme_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionType EventSectionType_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionType"
    ADD CONSTRAINT "EventSectionType_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionUserVisit EventSectionUserVisit_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionUserVisit"
    ADD CONSTRAINT "EventSectionUserVisit_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSectionVote EventSectionVote_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSectionVote"
    ADD CONSTRAINT "EventSectionVote_pkey" PRIMARY KEY ("Id");


--
-- Name: EventSection EventSection_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventSection"
    ADD CONSTRAINT "EventSection_pkey" PRIMARY KEY ("Id");


--
-- Name: EventType EventType_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventType"
    ADD CONSTRAINT "EventType_pkey" PRIMARY KEY ("Id");


--
-- Name: EventUserAdditionalAttribute EventUserAdditionalAttribute_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventUserAdditionalAttribute"
    ADD CONSTRAINT "EventUserAdditionalAttribute_pkey" PRIMARY KEY ("Id");


--
-- Name: EventUserData EventUserData_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventUserData"
    ADD CONSTRAINT "EventUserData_pkey" PRIMARY KEY ("Id");


--
-- Name: EventWidgetClass EventWidgetClass_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventWidgetClass"
    ADD CONSTRAINT "EventWidgetClass_pkey" PRIMARY KEY ("Id");


--
-- Name: EventLinkWidget EventWidget_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventLinkWidget"
    ADD CONSTRAINT "EventWidget_pkey" PRIMARY KEY ("Id");


--
-- Name: Event Event_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Event"
    ADD CONSTRAINT "Event_pkey" PRIMARY KEY ("Id");


--
-- Name: GeoCity Geo2City_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "GeoCity"
    ADD CONSTRAINT "Geo2City_pkey" PRIMARY KEY ("Id");


--
-- Name: GeoCountry Geo2Country_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "GeoCountry"
    ADD CONSTRAINT "Geo2Country_pkey" PRIMARY KEY ("Id");


--
-- Name: GeoRegion Geo2Region_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "GeoRegion"
    ADD CONSTRAINT "Geo2Region_pkey" PRIMARY KEY ("Id");


--
-- Name: IctRole IctRole_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IctRole"
    ADD CONSTRAINT "IctRole_pkey" PRIMARY KEY ("Id");


--
-- Name: IctUser IctUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IctUser"
    ADD CONSTRAINT "IctUser_pkey" PRIMARY KEY ("Id");


--
-- Name: IriRole IriRole_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IriRole"
    ADD CONSTRAINT "IriRole_pkey" PRIMARY KEY ("Id");


--
-- Name: IriUser IriUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IriUser"
    ADD CONSTRAINT "IriUser_pkey" PRIMARY KEY ("Id");


--
-- Name: JobCategory JobCategory_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "JobCategory"
    ADD CONSTRAINT "JobCategory_pkey" PRIMARY KEY ("Id");


--
-- Name: JobCompany JobCompany_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "JobCompany"
    ADD CONSTRAINT "JobCompany_pkey" PRIMARY KEY ("Id");


--
-- Name: JobPosition JobPosition_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "JobPosition"
    ADD CONSTRAINT "JobPosition_pkey" PRIMARY KEY ("Id");


--
-- Name: JobUp JobUp_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "JobUp"
    ADD CONSTRAINT "JobUp_pkey" PRIMARY KEY ("Id");


--
-- Name: Job Jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Job"
    ADD CONSTRAINT "Jobs_pkey" PRIMARY KEY ("Id");


--
-- Name: Link Link_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Link"
    ADD CONSTRAINT "Link_pkey" PRIMARY KEY ("Id");


--
-- Name: MailLog MailLog_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "MailLog"
    ADD CONSTRAINT "MailLog_pkey" PRIMARY KEY ("Id");


--
-- Name: MailTemplate MailTemplate_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "MailTemplate"
    ADD CONSTRAINT "MailTemplate_pkey" PRIMARY KEY ("Id");


--
-- Name: News News_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "News"
    ADD CONSTRAINT "News_pkey" PRIMARY KEY ("Id");


--
-- Name: OAuthAccessToken OAuthAccessToken_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OAuthAccessToken"
    ADD CONSTRAINT "OAuthAccessToken_pkey" PRIMARY KEY ("Id");


--
-- Name: OAuthPermission OAuthPermission_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OAuthPermission"
    ADD CONSTRAINT "OAuthPermission_pkey" PRIMARY KEY ("Id");


--
-- Name: OAuthSocial OAuthSocial_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OAuthSocial"
    ADD CONSTRAINT "OAuthSocial_pkey" PRIMARY KEY ("Id");


--
-- Name: PaperlessDeviceSignal PaperlessDeviceSignal_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDeviceSignal"
    ADD CONSTRAINT "PaperlessDeviceSignal_pkey" PRIMARY KEY ("Id");


--
-- Name: PaperlessDevice PaperlessDevice_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDevice"
    ADD CONSTRAINT "PaperlessDevice_pkey" PRIMARY KEY ("Id");


--
-- Name: PaperlessEventLinkDevice PaperlessEventLinkDevice_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkDevice"
    ADD CONSTRAINT "PaperlessEventLinkDevice_pkey" PRIMARY KEY ("Id");


--
-- Name: PaperlessEventLinkMaterial PaperlessEventLinkMaterial_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkMaterial"
    ADD CONSTRAINT "PaperlessEventLinkMaterial_pkey" PRIMARY KEY ("Id");


--
-- Name: PaperlessEventLinkRole PaperlessEventLinkRole_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkRole"
    ADD CONSTRAINT "PaperlessEventLinkRole_pkey" PRIMARY KEY ("Id");


--
-- Name: PaperlessEvent PaperlessEvent_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEvent"
    ADD CONSTRAINT "PaperlessEvent_pkey" PRIMARY KEY ("Id");


--
-- Name: PaperlessMaterialLinkRole PaperlessMaterialLinkRole_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterialLinkRole"
    ADD CONSTRAINT "PaperlessMaterialLinkRole_pkey" PRIMARY KEY ("Id");


--
-- Name: PaperlessMaterialLinkUser PaperlessMaterialLinkUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterialLinkUser"
    ADD CONSTRAINT "PaperlessMaterialLinkUser_pkey" PRIMARY KEY ("Id");


--
-- Name: PaperlessMaterial PaperlessMaterial_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterial"
    ADD CONSTRAINT "PaperlessMaterial_pkey" PRIMARY KEY ("Id");


--
-- Name: PartnerAccount PartnerAccount_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerAccount"
    ADD CONSTRAINT "PartnerAccount_pkey" PRIMARY KEY ("Id");


--
-- Name: PartnerCallbackUser PartnerCallbackUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerCallbackUser"
    ADD CONSTRAINT "PartnerCallbackUser_pkey" PRIMARY KEY ("Id");


--
-- Name: PartnerCallback PartnerCallback_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerCallback"
    ADD CONSTRAINT "PartnerCallback_pkey" PRIMARY KEY ("Id");


--
-- Name: PartnerExport PartnerExport_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerExport"
    ADD CONSTRAINT "PartnerExport_pkey" PRIMARY KEY ("Id");


--
-- Name: PartnerImportUser PartnerImportUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerImportUser"
    ADD CONSTRAINT "PartnerImportUser_pkey" PRIMARY KEY ("Id");


--
-- Name: PartnerImport PartnerImport_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerImport"
    ADD CONSTRAINT "PartnerImport_pkey" PRIMARY KEY ("Id");


--
-- Name: PayAccount PayAccount_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayAccount"
    ADD CONSTRAINT "PayAccount_pkey" PRIMARY KEY ("Id");


--
-- Name: PayCollectionCouponAttribute PayCollectionCouponAttribute_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCollectionCouponAttribute"
    ADD CONSTRAINT "PayCollectionCouponAttribute_pkey" PRIMARY KEY ("Id");


--
-- Name: PayCollectionCouponLinkProduct PayCollectionCouponLinkProduct_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCollectionCouponLinkProduct"
    ADD CONSTRAINT "PayCollectionCouponLinkProduct_pkey" PRIMARY KEY ("CollectionCouponId", "ProductId");


--
-- Name: PayCollectionCoupon PayCollectionCoupon_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCollectionCoupon"
    ADD CONSTRAINT "PayCollectionCoupon_pkey" PRIMARY KEY ("Id");


--
-- Name: PayCouponActivation PayCouponActivated_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCouponActivation"
    ADD CONSTRAINT "PayCouponActivated_pkey" PRIMARY KEY ("Id");


--
-- Name: PayCouponActivationLinkOrderItem PayCouponActivationLinkOrderItem_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCouponActivationLinkOrderItem"
    ADD CONSTRAINT "PayCouponActivationLinkOrderItem_pkey" PRIMARY KEY ("Id");


--
-- Name: PayCouponLinkProduct PayCouponLinkProduct_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCouponLinkProduct"
    ADD CONSTRAINT "PayCouponLinkProduct_pkey" PRIMARY KEY ("CouponId", "ProductId");


--
-- Name: PayCoupon PayCoupon_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCoupon"
    ADD CONSTRAINT "PayCoupon_pkey" PRIMARY KEY ("Id");


--
-- Name: PayFoodPartnerOrderItem PayFoodPartnerOrderItem_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayFoodPartnerOrderItem"
    ADD CONSTRAINT "PayFoodPartnerOrderItem_pkey" PRIMARY KEY ("Id");


--
-- Name: PayFoodPartnerOrder PayFoodPartnerOrder_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayFoodPartnerOrder"
    ADD CONSTRAINT "PayFoodPartnerOrder_pkey" PRIMARY KEY ("Id");


--
-- Name: PayLog PayLog_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayLog"
    ADD CONSTRAINT "PayLog_pkey" PRIMARY KEY ("Id");


--
-- Name: PayLoyaltyProgramDiscount PayLoyaltyProgram_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayLoyaltyProgramDiscount"
    ADD CONSTRAINT "PayLoyaltyProgram_pkey" PRIMARY KEY ("Id");


--
-- Name: PayOrderImportEntry PayOrderImportOrder_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderImportEntry"
    ADD CONSTRAINT "PayOrderImportOrder_pkey" PRIMARY KEY ("Id");


--
-- Name: PayOrderImportOrder PayOrderImportOrder_pkey1; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderImportOrder"
    ADD CONSTRAINT "PayOrderImportOrder_pkey1" PRIMARY KEY ("Id");


--
-- Name: PayOrderImport PayOrderImport_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderImport"
    ADD CONSTRAINT "PayOrderImport_pkey" PRIMARY KEY ("Id");


--
-- Name: PayOrderItemAttribute PayOrderItemAttribute_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderItemAttribute"
    ADD CONSTRAINT "PayOrderItemAttribute_pkey" PRIMARY KEY ("Id");


--
-- Name: PayOrderItem PayOrderItem_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderItem"
    ADD CONSTRAINT "PayOrderItem_pkey" PRIMARY KEY ("Id");


--
-- Name: PayOrderJuridicalTemplate PayOrderJuridicalTemplate_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderJuridicalTemplate"
    ADD CONSTRAINT "PayOrderJuridicalTemplate_pkey" PRIMARY KEY ("Id");


--
-- Name: PayOrderJuridical PayOrderJuridical_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderJuridical"
    ADD CONSTRAINT "PayOrderJuridical_pkey" PRIMARY KEY ("Id");


--
-- Name: PayOrderLinkOrderItem PayOrderLinkOrderItem_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderLinkOrderItem"
    ADD CONSTRAINT "PayOrderLinkOrderItem_pkey" PRIMARY KEY ("Id");


--
-- Name: PayOrder PayOrder_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrder"
    ADD CONSTRAINT "PayOrder_pkey" PRIMARY KEY ("Id");


--
-- Name: PayProductAttribute PayProductAttribute_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProductAttribute"
    ADD CONSTRAINT "PayProductAttribute_pkey" PRIMARY KEY ("Id");


--
-- Name: PayProductCheck PayProductGet_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProductCheck"
    ADD CONSTRAINT "PayProductGet_pkey" PRIMARY KEY ("Id");


--
-- Name: PayProductPrice PayProductPrice_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProductPrice"
    ADD CONSTRAINT "PayProductPrice_pkey" PRIMARY KEY ("Id");


--
-- Name: PayProductUserAccess PayProductUserAccess_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProductUserAccess"
    ADD CONSTRAINT "PayProductUserAccess_pkey" PRIMARY KEY ("Id");


--
-- Name: PayProduct PayProduct_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProduct"
    ADD CONSTRAINT "PayProduct_pkey" PRIMARY KEY ("Id");


--
-- Name: PayReferralDiscount PayReferralDiscount_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayReferralDiscount"
    ADD CONSTRAINT "PayReferralDiscount_pkey" PRIMARY KEY ("Id");


--
-- Name: PayRoomPartnerBooking PayRoomPartnerBooking_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayRoomPartnerBooking"
    ADD CONSTRAINT "PayRoomPartnerBooking_pkey" PRIMARY KEY ("Id");


--
-- Name: PayRoomPartnerOrder PayRoomPartnerOrder_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayRoomPartnerOrder"
    ADD CONSTRAINT "PayRoomPartnerOrder_pkey" PRIMARY KEY ("Id");


--
-- Name: ProfessionalInterest ProfessionalInterest_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ProfessionalInterest"
    ADD CONSTRAINT "ProfessionalInterest_pkey" PRIMARY KEY ("Id");


--
-- Name: RaecBriefLinkCompany RaecBriefCompany_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecBriefLinkCompany"
    ADD CONSTRAINT "RaecBriefCompany_pkey" PRIMARY KEY ("Id");


--
-- Name: RaecBriefLinkUser RaecBriefLinkUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecBriefLinkUser"
    ADD CONSTRAINT "RaecBriefLinkUser_pkey" PRIMARY KEY ("Id");


--
-- Name: RaecBriefUserRole RaecBriefUserRole_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecBriefUserRole"
    ADD CONSTRAINT "RaecBriefUserRole_pkey" PRIMARY KEY ("Id");


--
-- Name: RaecBrief RaecBrief_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecBrief"
    ADD CONSTRAINT "RaecBrief_pkey" PRIMARY KEY ("Id");


--
-- Name: RaecCompanyUserStatus RaecCompanyUserStatus_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecCompanyUserStatus"
    ADD CONSTRAINT "RaecCompanyUserStatus_pkey" PRIMARY KEY ("Id");


--
-- Name: RaecCompanyUser RaecCompanyUser_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecCompanyUser"
    ADD CONSTRAINT "RaecCompanyUser_pkey" PRIMARY KEY ("Id");


--
-- Name: RuventsAccount RuventsAccount_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsAccount"
    ADD CONSTRAINT "RuventsAccount_pkey" PRIMARY KEY ("Id");


--
-- Name: RuventsBadge RuventsBadge_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsBadge"
    ADD CONSTRAINT "RuventsBadge_pkey" PRIMARY KEY ("Id");


--
-- Name: RuventsDetailLog RuventsDetailLog_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsDetailLog"
    ADD CONSTRAINT "RuventsDetailLog_pkey" PRIMARY KEY ("Id");


--
-- Name: RuventsOperator RuventsOperator_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsOperator"
    ADD CONSTRAINT "RuventsOperator_pkey" PRIMARY KEY ("Id");


--
-- Name: RuventsSetting RuventsSetting_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsSetting"
    ADD CONSTRAINT "RuventsSetting_pkey" PRIMARY KEY ("Id");


--
-- Name: RuventsVisit RuventsVisit_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsVisit"
    ADD CONSTRAINT "RuventsVisit_pkey" PRIMARY KEY ("Id");


--
-- Name: Tag Tag_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Tag"
    ADD CONSTRAINT "Tag_pkey" PRIMARY KEY ("Id");


--
-- Name: TmpRifParking TmpRifParking_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "TmpRifParking"
    ADD CONSTRAINT "TmpRifParking_pkey" PRIMARY KEY ("Id");


--
-- Name: Translation Translation_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Translation"
    ADD CONSTRAINT "Translation_pkey" PRIMARY KEY ("Id");


--
-- Name: UserDevice UserDevice_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserDevice"
    ADD CONSTRAINT "UserDevice_pkey" PRIMARY KEY ("Id");


--
-- Name: UserDocumentType UserDocumentType_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserDocumentType"
    ADD CONSTRAINT "UserDocumentType_pkey" PRIMARY KEY ("Id");


--
-- Name: UserDocument UserDocument_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserDocument"
    ADD CONSTRAINT "UserDocument_pkey" PRIMARY KEY ("Id");


--
-- Name: UserEducation UserEducation_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserEducation"
    ADD CONSTRAINT "UserEducation_pkey" PRIMARY KEY ("Id");


--
-- Name: UserEmployment UserEmployment_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserEmployment"
    ADD CONSTRAINT "UserEmployment_pkey" PRIMARY KEY ("Id");


--
-- Name: UserLinkAddress UserLinkAddress_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkAddress"
    ADD CONSTRAINT "UserLinkAddress_pkey" PRIMARY KEY ("Id");


--
-- Name: UserLinkEmail UserLinkEmail_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkEmail"
    ADD CONSTRAINT "UserLinkEmail_pkey" PRIMARY KEY ("Id");


--
-- Name: UserLinkPhone UserLinkPhone_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkPhone"
    ADD CONSTRAINT "UserLinkPhone_pkey" PRIMARY KEY ("Id");


--
-- Name: UserLinkProfessionalInterest UserLinkProfessionalInterest_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkProfessionalInterest"
    ADD CONSTRAINT "UserLinkProfessionalInterest_pkey" PRIMARY KEY ("Id");


--
-- Name: UserLinkServiceAccount UserLinkServiceAccount_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkServiceAccount"
    ADD CONSTRAINT "UserLinkServiceAccount_pkey" PRIMARY KEY ("Id");


--
-- Name: UserLinkSite UserLinkSite_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLinkSite"
    ADD CONSTRAINT "UserLinkSite_pkey" PRIMARY KEY ("Id");


--
-- Name: UserLoyaltyProgram UserLoyaltyProgram_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserLoyaltyProgram"
    ADD CONSTRAINT "UserLoyaltyProgram_pkey" PRIMARY KEY ("Id");


--
-- Name: UserReferral UserReferral_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserReferral"
    ADD CONSTRAINT "UserReferral_pkey" PRIMARY KEY ("Id");


--
-- Name: UserSettings UserSettings_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserSettings"
    ADD CONSTRAINT "UserSettings_pkey" PRIMARY KEY ("Id");


--
-- Name: UserUnsubscribeEventMail UserUnsubscribeEventMail_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserUnsubscribeEventMail"
    ADD CONSTRAINT "UserUnsubscribeEventMail_pkey" PRIMARY KEY ("Id");


--
-- Name: User User_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "User"
    ADD CONSTRAINT "User_pkey" PRIMARY KEY ("Id");


--
-- Name: YiiSession YiiSession_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "YiiSession"
    ADD CONSTRAINT "YiiSession_pkey" PRIMARY KEY (id);


--
-- Name: tbl_migration tbl_migration_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_migration
    ADD CONSTRAINT tbl_migration_pkey PRIMARY KEY (version);


--
-- Name: ApiExternalUser_AccountId_UserId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "ApiExternalUser_AccountId_UserId_index" ON "ApiExternalUser" USING btree ("AccountId", "UserId");


--
-- Name: AttributeDefinition_ClassName_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "AttributeDefinition_ClassName_index" ON "AttributeDefinition" USING btree ("ClassName");


--
-- Name: AttributeDefinition_GroupId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "AttributeDefinition_GroupId_index" ON "AttributeDefinition" USING btree ("GroupId");


--
-- Name: AttributeGroup_Id_key; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "AttributeGroup_Id_key" ON "AttributeGroup" USING btree ("Id");


--
-- Name: AttributeGroup_ModelName_ModelId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "AttributeGroup_ModelName_ModelId_index" ON "AttributeGroup" USING btree ("ModelName", "ModelId");


--
-- Name: CompanyLinkModerator_UserId_CompanyId_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "CompanyLinkModerator_UserId_CompanyId_idx" ON "CompanyLinkModerator" USING btree ("UserId", "CompanyId");


--
-- Name: Company_Cluster_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Company_Cluster_idx" ON "Company" USING btree ("Cluster");


--
-- Name: Company_FullName_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Company_FullName_idx" ON "Company" USING btree ("FullName");


--
-- Name: Company_Id_key; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "Company_Id_key" ON "Company" USING btree ("Id");


--
-- Name: Company_Name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Company_Name_idx" ON "Company" USING btree ("Name");


--
-- Name: Company_Name_trgm; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Company_Name_trgm" ON "Company" USING gin ("Name" gin_trgm_ops);


--
-- Name: EducationFaculty_UniversityId_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "EducationFaculty_UniversityId_idx" ON "EducationFaculty" USING btree ("UniversityId");


--
-- Name: EducationUniversity_CityId_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "EducationUniversity_CityId_idx" ON "EducationUniversity" USING btree ("CityId");


--
-- Name: Employment_CompanyId_key; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Employment_CompanyId_key" ON "UserEmployment" USING btree ("CompanyId");


--
-- Name: Employment_UserId_key; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Employment_UserId_key" ON "UserEmployment" USING btree ("UserId");


--
-- Name: EventParticipant_PartId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "EventParticipant_PartId_index" ON "EventParticipant" USING btree ("PartId");


--
-- Name: EventParticipant_RoleId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "EventParticipant_RoleId_index" ON "EventParticipant" USING btree ("RoleId");


--
-- Name: EventParticipant_UserId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "EventParticipant_UserId_index" ON "EventParticipant" USING btree ("UserId");


--
-- Name: EventSectionFavorite_UserId_Deleted_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "EventSectionFavorite_UserId_Deleted_index" ON "EventSectionFavorite" USING btree ("UserId", "Deleted");


--
-- Name: EventSection_EventId_Deleted_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "EventSection_EventId_Deleted_index" ON "EventSection" USING btree ("EventId", "Deleted");


--
-- Name: EventUserData_EventId_UserId_Deleted_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "EventUserData_EventId_UserId_Deleted_index" ON "EventUserData" USING btree ("EventId", "UserId", "Deleted");


--
-- Name: EventUserData_UserId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "EventUserData_UserId_index" ON "EventUserData" USING btree ("UserId");


--
-- Name: Event_EventId_key; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "Event_EventId_key" ON "Event" USING btree ("Id");


--
-- Name: Geo2City_CountryId_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Geo2City_CountryId_idx" ON "GeoCity" USING btree ("CountryId");


--
-- Name: Geo2City_Name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Geo2City_Name_idx" ON "GeoCity" USING btree ("Name");


--
-- Name: Geo2City_RegionId_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Geo2City_RegionId_idx" ON "GeoCity" USING btree ("RegionId");


--
-- Name: Geo2City_SearchName_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Geo2City_SearchName_idx" ON "GeoCity" USING gin ("SearchName");


--
-- Name: Geo2Region_CountryId_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Geo2Region_CountryId_idx" ON "GeoRegion" USING btree ("CountryId");


--
-- Name: GeoRegion_SearchName_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "GeoRegion_SearchName_idx" ON "GeoRegion" USING gin ("SearchName");


--
-- Name: Hash; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Hash" ON "ShortUrl" USING hash ("Hash");


--
-- Name: Hash_btree; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Hash_btree" ON "RuventsAccount" USING btree ("Hash");


--
-- Name: IKey_CouponLinkOrderItem; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IKey_CouponLinkOrderItem" ON "PayCouponActivationLinkOrderItem" USING btree ("OrderItemId");


--
-- Name: Index_Participant_EventId; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Index_Participant_EventId" ON "EventParticipant" USING btree ("EventId");


--
-- Name: IriUser_UserId_ExitTime_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IriUser_UserId_ExitTime_index" ON "IriUser" USING btree ("UserId", "ExitTime");


--
-- Name: Job_Url_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Job_Url_index" ON "Job" USING btree ("Url");


--
-- Name: MailLog_Hash_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "MailLog_Hash_idx" ON "MailLog" USING hash ("Hash");


--
-- Name: PaperlessDeviceSignal_EventId_DeviceId_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "PaperlessDeviceSignal_EventId_DeviceId_idx" ON "PaperlessDeviceSignal" USING btree ("EventId", "DeviceNumber");


--
-- Name: PaperlessDeviceSignal_Processed_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "PaperlessDeviceSignal_Processed_idx" ON "PaperlessDeviceSignal" USING btree ("EventId", "DeviceNumber");


--
-- Name: PayCoupon_EventId_Code_key; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "PayCoupon_EventId_Code_key" ON "PayCoupon" USING btree ("EventId", "Code");


--
-- Name: PayOrderItem_ChangedOwnerId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "PayOrderItem_ChangedOwnerId_index" ON "PayOrderItem" USING btree ("ChangedOwnerId");


--
-- Name: PayOrderItem_Deleted_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "PayOrderItem_Deleted_index" ON "PayOrderItem" USING btree ("Deleted");


--
-- Name: PayOrderItem_OwnerId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "PayOrderItem_OwnerId_index" ON "PayOrderItem" USING btree ("OwnerId");


--
-- Name: PayOrderItem_Paid_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "PayOrderItem_Paid_index" ON "PayOrderItem" USING btree ("Paid");


--
-- Name: PayOrderItem_ProductId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "PayOrderItem_ProductId_index" ON "PayOrderItem" USING btree ("ProductId");


--
-- Name: PayOrderItem_Refund_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "PayOrderItem_Refund_index" ON "PayOrderItem" USING btree ("Refund");


--
-- Name: RuventsBadge_EventId_UserId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "RuventsBadge_EventId_UserId_index" ON "RuventsBadge" USING btree ("EventId", "UserId");


--
-- Name: RuventsVisit_MarkId_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "RuventsVisit_MarkId_idx" ON "RuventsVisit" USING btree ("MarkId");


--
-- Name: TranslationSearchIndex; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "TranslationSearchIndex" ON "Translation" USING btree ("ResourceId", "ResourceName");


--
-- Name: Translation_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "Translation_idx" ON "Translation" USING gin ("Value" gin_trgm_ops);


--
-- Name: UrlHash; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "UrlHash" ON "News" USING btree ("UrlHash");


--
-- Name: UserDevice_Token; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "UserDevice_Token" ON "UserDevice" USING btree ("Token");


--
-- Name: UserEducation_UserId_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "UserEducation_UserId_idx" ON "UserEducation" USING btree ("UserId");


--
-- Name: UserLinkAddress_UserId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "UserLinkAddress_UserId_index" ON "UserLinkAddress" USING btree ("UserId");


--
-- Name: UserLinkPhone_PhoneId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "UserLinkPhone_PhoneId_index" ON "UserLinkPhone" USING btree ("PhoneId");


--
-- Name: UserLinkPhone_UserId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "UserLinkPhone_UserId_index" ON "UserLinkPhone" USING btree ("UserId");


--
-- Name: UserLinkServiceAccount_UserId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "UserLinkServiceAccount_UserId_index" ON "UserLinkServiceAccount" USING btree ("UserId");


--
-- Name: UserLinkSite_UserId_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "UserLinkSite_UserId_index" ON "UserLinkSite" USING btree ("UserId");


--
-- Name: UserSettings_UserId_key; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "UserSettings_UserId_key" ON "UserSettings" USING btree ("UserId");


--
-- Name: User_Email_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "User_Email_idx" ON "User" USING btree ("Email");


--
-- Name: User_FatherName_trgm; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "User_FatherName_trgm" ON "User" USING gin ("FatherName" gin_trgm_ops);


--
-- Name: User_FirstName_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "User_FirstName_idx" ON "User" USING btree ("FirstName");


--
-- Name: User_FirstName_trgm; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "User_FirstName_trgm" ON "User" USING gin ("FirstName" gin_trgm_ops);


--
-- Name: User_FullName_key; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "User_FullName_key" ON "User" USING btree ("LastName", "FirstName", "FatherName");


--
-- Name: User_LastName_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "User_LastName_idx" ON "User" USING btree ("LastName");


--
-- Name: User_LastName_trgm; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "User_LastName_trgm" ON "User" USING gin ("LastName" gin_trgm_ops);


--
-- Name: User_RunetId_key; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "User_RunetId_key" ON "User" USING btree ("RunetId");


--
-- Name: User_SearchFirstName_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "User_SearchFirstName_idx" ON "User" USING gin ("SearchFirstName");


--
-- Name: User_SearchLastName_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "User_SearchLastName_idx" ON "User" USING gin ("SearchLastName");


--
-- Name: User_UpdateTime_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "User_UpdateTime_index" ON "User" USING btree ("UpdateTime");


--
-- Name: User_UserId_key; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "User_UserId_key" ON "User" USING btree ("Id");


--
-- Name: YiiSession_expire_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "YiiSession_expire_idx" ON "YiiSession" USING btree (expire);


--
-- Name: fki_CompetenceTest_RoleIdAfterPass_fkey; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "fki_CompetenceTest_RoleIdAfterPass_fkey" ON "CompetenceTest" USING btree ("RoleIdAfterPass");


--
-- Name: fki_PayOrderLinkOrderItem_OrderId_fkey; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "fki_PayOrderLinkOrderItem_OrderId_fkey" ON "PayOrderLinkOrderItem" USING btree ("OrderId");


--
-- Name: fki_PayOrderLinkOrderItem_OrderItemId_fkey; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "fki_PayOrderLinkOrderItem_OrderItemId_fkey" ON "PayOrderLinkOrderItem" USING btree ("OrderItemId");


--
-- Name: fki_PayProductPrice_ProductId_fkey; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "fki_PayProductPrice_ProductId_fkey" ON "PayProductPrice" USING btree ("ProductId");


--
-- Name: idx_pl_ns; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX idx_pl_ns ON "PayLog" USING btree ("NotificationSent", "Error");


--
-- Name: User BeforeUpdate; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "BeforeUpdate" BEFORE UPDATE ON "User" FOR EACH ROW EXECUTE PROCEDURE "UserUpdate"();


--
-- Name: UserDocument CheckActual; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "CheckActual" AFTER INSERT OR UPDATE ON "UserDocument" FOR EACH ROW EXECUTE PROCEDURE "CheckUserDocumentActual"();


--
-- Name: UserEmployment CheckPrimary; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "CheckPrimary" AFTER INSERT OR UPDATE ON "UserEmployment" FOR EACH ROW EXECUTE PROCEDURE "CheckEmploymentPrimary"();


--
-- Name: UserEmployment CheckPrimaryBefore; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "CheckPrimaryBefore" BEFORE INSERT OR UPDATE ON "UserEmployment" FOR EACH ROW EXECUTE PROCEDURE "CheckEmploymentBefore"();


--
-- Name: User CreateUserSettingsTrigger; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "CreateUserSettingsTrigger" AFTER INSERT ON "User" FOR EACH ROW EXECUTE PROCEDURE createusersettings();


--
-- Name: ContactAddress IncrementGeoCityPriority; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "IncrementGeoCityPriority" AFTER INSERT OR UPDATE ON "ContactAddress" FOR EACH ROW EXECUTE PROCEDURE "IncrementGeoCityPriority"();


--
-- Name: EducationUniversity IncrementGeoCityPriority; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "IncrementGeoCityPriority" AFTER INSERT OR UPDATE ON "EducationUniversity" FOR EACH ROW EXECUTE PROCEDURE "IncrementGeoCityPriority"();


--
-- Name: UserEmployment UpdateUser; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "UpdateUser" AFTER INSERT OR DELETE OR UPDATE ON "UserEmployment" FOR EACH ROW EXECUTE PROCEDURE "UserUpdateTimeByUserId"();


--
-- Name: EventParticipant UpdateUser; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "UpdateUser" AFTER INSERT OR DELETE OR UPDATE ON "EventParticipant" FOR EACH ROW EXECUTE PROCEDURE "UserUpdateTimeByUserId"();


--
-- Name: PayOrderItem UpdateUser; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "UpdateUser" AFTER INSERT OR DELETE OR UPDATE ON "PayOrderItem" FOR EACH ROW EXECUTE PROCEDURE "UserUpdateTimeByOwnerId"();


--
-- Name: EventUserData UpdateUser; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER "UpdateUser" AFTER INSERT OR DELETE OR UPDATE ON "EventUserData" FOR EACH ROW EXECUTE PROCEDURE "UserUpdateTimeByUserId"();


--
-- Name: AttributeDefinition AttributeDefinition_GroupId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "AttributeDefinition"
    ADD CONSTRAINT "AttributeDefinition_GroupId_fkey" FOREIGN KEY ("GroupId") REFERENCES "AttributeGroup"("Id") ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: CompanyLinkCommission CompanyLinkCommission_CommissionId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkCommission"
    ADD CONSTRAINT "CompanyLinkCommission_CommissionId_fkey" FOREIGN KEY ("CommissionId") REFERENCES "Commission"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: CompanyLinkCommission CompanyLinkCommission_CompanyId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkCommission"
    ADD CONSTRAINT "CompanyLinkCommission_CompanyId_fkey" FOREIGN KEY ("CompanyId") REFERENCES "Company"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: CompanyLinkProfessionalInterest CompanyLinkProfessionalInterest_CompanyId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkProfessionalInterest"
    ADD CONSTRAINT "CompanyLinkProfessionalInterest_CompanyId_fkey" FOREIGN KEY ("CompanyId") REFERENCES "Company"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: CompanyLinkProfessionalInterest CompanyLinkProfessionalInterest_ProfessionalInterestId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompanyLinkProfessionalInterest"
    ADD CONSTRAINT "CompanyLinkProfessionalInterest_ProfessionalInterestId_fkey" FOREIGN KEY ("ProfessionalInterestId") REFERENCES "ProfessionalInterest"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: CompetenceTest CompetenceTest_RoleIdAfterPass_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CompetenceTest"
    ADD CONSTRAINT "CompetenceTest_RoleIdAfterPass_fkey" FOREIGN KEY ("RoleIdAfterPass") REFERENCES "EventRole"("Id") ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: ConnectMeetingLinkUser ConnectMeetingLinkUser_MeetingId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ConnectMeetingLinkUser"
    ADD CONSTRAINT "ConnectMeetingLinkUser_MeetingId_fkey" FOREIGN KEY ("MeetingId") REFERENCES "ConnectMeeting"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ConnectMeetingLinkUser ConnectMeetingLinkUser_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ConnectMeetingLinkUser"
    ADD CONSTRAINT "ConnectMeetingLinkUser_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ContactAddress ContactAddress_CityId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactAddress"
    ADD CONSTRAINT "ContactAddress_CityId_fkey" FOREIGN KEY ("CityId") REFERENCES "GeoCity"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: ContactAddress ContactAddress_CountryId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactAddress"
    ADD CONSTRAINT "ContactAddress_CountryId_fkey" FOREIGN KEY ("CountryId") REFERENCES "GeoCountry"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: ContactAddress ContactAddress_RegionId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ContactAddress"
    ADD CONSTRAINT "ContactAddress_RegionId_fkey" FOREIGN KEY ("RegionId") REFERENCES "GeoRegion"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: EducationFaculty EducationFaculty_UniversityId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EducationFaculty"
    ADD CONSTRAINT "EducationFaculty_UniversityId_fkey" FOREIGN KEY ("UniversityId") REFERENCES "EducationUniversity"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: EducationUniversity EducationUniversity_CityId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EducationUniversity"
    ADD CONSTRAINT "EducationUniversity_CityId_fkey" FOREIGN KEY ("CityId") REFERENCES "GeoCity"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: UserEmployment Employment_Company_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserEmployment"
    ADD CONSTRAINT "Employment_Company_foreign" FOREIGN KEY ("CompanyId") REFERENCES "Company"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: EventParticipant EventParticipant_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventParticipant"
    ADD CONSTRAINT "EventParticipant_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: GeoCity Geo2City_CountryId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "GeoCity"
    ADD CONSTRAINT "Geo2City_CountryId_fkey" FOREIGN KEY ("CountryId") REFERENCES "GeoCountry"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: GeoCity Geo2City_RegionId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "GeoCity"
    ADD CONSTRAINT "Geo2City_RegionId_fkey" FOREIGN KEY ("RegionId") REFERENCES "GeoRegion"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: GeoRegion Geo2Region_CountryId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "GeoRegion"
    ADD CONSTRAINT "Geo2Region_CountryId_fkey" FOREIGN KEY ("CountryId") REFERENCES "GeoCountry"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: IctUser IctUser_ProfessionalInterestId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IctUser"
    ADD CONSTRAINT "IctUser_ProfessionalInterestId_fkey" FOREIGN KEY ("ProfessionalInterestId") REFERENCES "ProfessionalInterest"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: IctUser IctUser_RoleId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IctUser"
    ADD CONSTRAINT "IctUser_RoleId_fkey" FOREIGN KEY ("RoleId") REFERENCES "IctRole"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: IctUser IctUser_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IctUser"
    ADD CONSTRAINT "IctUser_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: IriUser IriUser_ProfessionalInterestId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IriUser"
    ADD CONSTRAINT "IriUser_ProfessionalInterestId_fkey" FOREIGN KEY ("ProfessionalInterestId") REFERENCES "ProfessionalInterest"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: IriUser IriUser_RoleId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IriUser"
    ADD CONSTRAINT "IriUser_RoleId_fkey" FOREIGN KEY ("RoleId") REFERENCES "IriRole"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: IriUser IriUser_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IriUser"
    ADD CONSTRAINT "IriUser_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PayCouponActivationLinkOrderItem Key_ActivationLinkOrderItem; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCouponActivationLinkOrderItem"
    ADD CONSTRAINT "Key_ActivationLinkOrderItem" FOREIGN KEY ("OrderItemId") REFERENCES "PayOrderItem"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PartnerExport PartnerExport_EventId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerExport"
    ADD CONSTRAINT "PartnerExport_EventId_fkey" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PartnerExport PartnerExport_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PartnerExport"
    ADD CONSTRAINT "PartnerExport_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PayCollectionCouponLinkProduct PayCollectionCouponLinkProduct_CouponId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCollectionCouponLinkProduct"
    ADD CONSTRAINT "PayCollectionCouponLinkProduct_CouponId_fkey" FOREIGN KEY ("CollectionCouponId") REFERENCES "PayCollectionCoupon"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PayCollectionCouponLinkProduct PayCollectionCouponLinkProduct_ProductId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayCollectionCouponLinkProduct"
    ADD CONSTRAINT "PayCollectionCouponLinkProduct_ProductId_fkey" FOREIGN KEY ("ProductId") REFERENCES "PayProduct"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PayFoodPartnerOrderItem PayFoodPartnerOrderItem_OrderId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayFoodPartnerOrderItem"
    ADD CONSTRAINT "PayFoodPartnerOrderItem_OrderId_fkey" FOREIGN KEY ("OrderId") REFERENCES "PayFoodPartnerOrder"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PayFoodPartnerOrderItem PayFoodPartnerOrderItem_ProductId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayFoodPartnerOrderItem"
    ADD CONSTRAINT "PayFoodPartnerOrderItem_ProductId_fkey" FOREIGN KEY ("ProductId") REFERENCES "PayProduct"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PayFoodPartnerOrder PayFoodPartnerOrder_EventId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayFoodPartnerOrder"
    ADD CONSTRAINT "PayFoodPartnerOrder_EventId_fkey" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PayOrderImportEntry PayOrderImportEntry_ImportId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderImportEntry"
    ADD CONSTRAINT "PayOrderImportEntry_ImportId_fkey" FOREIGN KEY ("ImportId") REFERENCES "PayOrderImport"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PayOrderImportOrder PayOrderImportOrder_EntryId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderImportOrder"
    ADD CONSTRAINT "PayOrderImportOrder_EntryId_fkey" FOREIGN KEY ("EntryId") REFERENCES "PayOrderImportEntry"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PayOrderImportOrder PayOrderImportOrder_OrderId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderImportOrder"
    ADD CONSTRAINT "PayOrderImportOrder_OrderId_fkey" FOREIGN KEY ("OrderId") REFERENCES "PayOrder"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PayOrderLinkOrderItem PayOrderLinkOrderItem_OrderId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderLinkOrderItem"
    ADD CONSTRAINT "PayOrderLinkOrderItem_OrderId_fkey" FOREIGN KEY ("OrderId") REFERENCES "PayOrder"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PayOrderLinkOrderItem PayOrderLinkOrderItem_OrderItemId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayOrderLinkOrderItem"
    ADD CONSTRAINT "PayOrderLinkOrderItem_OrderItemId_fkey" FOREIGN KEY ("OrderItemId") REFERENCES "PayOrderItem"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PayProductCheck PayProductCheck_OperatorId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProductCheck"
    ADD CONSTRAINT "PayProductCheck_OperatorId_fkey" FOREIGN KEY ("OperatorId") REFERENCES "RuventsOperator"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PayProductPrice PayProductPrice_ProductId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayProductPrice"
    ADD CONSTRAINT "PayProductPrice_ProductId_fkey" FOREIGN KEY ("ProductId") REFERENCES "PayProduct"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PayReferralDiscount PayReferralDiscount_EventId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayReferralDiscount"
    ADD CONSTRAINT "PayReferralDiscount_EventId_fkey" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PayReferralDiscount PayReferralDiscount_ProductId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayReferralDiscount"
    ADD CONSTRAINT "PayReferralDiscount_ProductId_fkey" FOREIGN KEY ("ProductId") REFERENCES "PayProduct"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: PayRoomPartnerOrder PayRoomPartnerOrder_EventId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PayRoomPartnerOrder"
    ADD CONSTRAINT "PayRoomPartnerOrder_EventId_fkey" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: RaecCompanyUser RaecCompanyUser_CompanyId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecCompanyUser"
    ADD CONSTRAINT "RaecCompanyUser_CompanyId_fkey" FOREIGN KEY ("CompanyId") REFERENCES "Company"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: RaecCompanyUser RaecCompanyUser_StatusId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecCompanyUser"
    ADD CONSTRAINT "RaecCompanyUser_StatusId_fkey" FOREIGN KEY ("StatusId") REFERENCES "RaecCompanyUserStatus"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: RaecCompanyUser RaecCompanyUser_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RaecCompanyUser"
    ADD CONSTRAINT "RaecCompanyUser_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: RuventsSetting RuventsSetting_EventId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsSetting"
    ADD CONSTRAINT "RuventsSetting_EventId_fkey" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: RuventsVisit RuventsVisit_EventId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsVisit"
    ADD CONSTRAINT "RuventsVisit_EventId_fkey" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: RuventsVisit RuventsVisit_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "RuventsVisit"
    ADD CONSTRAINT "RuventsVisit_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: UserDevice UserDevice_UserId_fKey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserDevice"
    ADD CONSTRAINT "UserDevice_UserId_fKey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: UserDocument UserDocument_TypeId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserDocument"
    ADD CONSTRAINT "UserDocument_TypeId_fkey" FOREIGN KEY ("TypeId") REFERENCES "UserDocumentType"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: UserDocument UserDocument_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserDocument"
    ADD CONSTRAINT "UserDocument_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: UserEducation UserEducation_FacultyId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserEducation"
    ADD CONSTRAINT "UserEducation_FacultyId_fkey" FOREIGN KEY ("FacultyId") REFERENCES "EducationFaculty"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: UserEducation UserEducation_UniversityId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserEducation"
    ADD CONSTRAINT "UserEducation_UniversityId_fkey" FOREIGN KEY ("UniversityId") REFERENCES "EducationUniversity"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: UserEducation UserEducation_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserEducation"
    ADD CONSTRAINT "UserEducation_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: UserEmployment UserEmployment_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserEmployment"
    ADD CONSTRAINT "UserEmployment_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: UserReferral UserReferral_EventId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserReferral"
    ADD CONSTRAINT "UserReferral_EventId_fkey" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: UserReferral UserReferral_ReferrerUserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserReferral"
    ADD CONSTRAINT "UserReferral_ReferrerUserId_fkey" FOREIGN KEY ("ReferrerUserId") REFERENCES "User"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: UserReferral UserReferral_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserReferral"
    ADD CONSTRAINT "UserReferral_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: UserSettings UserSettings_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "UserSettings"
    ADD CONSTRAINT "UserSettings_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: User User_MergeUserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "User"
    ADD CONSTRAINT "User_MergeUserId_fkey" FOREIGN KEY ("MergeUserId") REFERENCES "User"("Id") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: EventUserData eventuserdata_event_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventUserData"
    ADD CONSTRAINT eventuserdata_event_id_fk FOREIGN KEY ("EventId") REFERENCES "Event"("Id");


--
-- Name: ConnectMeeting fk_ConnectMeeting_EventMeetingPlace; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ConnectMeeting"
    ADD CONSTRAINT "fk_ConnectMeeting_EventMeetingPlace" FOREIGN KEY ("PlaceId") REFERENCES "EventMeetingPlace"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ConnectMeeting fk_ConnectMeeting_User__Creator; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ConnectMeeting"
    ADD CONSTRAINT "fk_ConnectMeeting_User__Creator" FOREIGN KEY ("CreatorId") REFERENCES "User"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: EventMeetingPlace fk_EventMeetingPlace_Event; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventMeetingPlace"
    ADD CONSTRAINT "fk_EventMeetingPlace_Event" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: EventMeetingPlace fk_EventMeetingPlace_parent; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "EventMeetingPlace"
    ADD CONSTRAINT "fk_EventMeetingPlace_parent" FOREIGN KEY ("ParentId") REFERENCES "EventMeetingPlace"("Id");


--
-- Name: PaperlessDeviceSignal fk_PaperlessDeviceSignal_Device; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDeviceSignal"
    ADD CONSTRAINT "fk_PaperlessDeviceSignal_Device" FOREIGN KEY ("DeviceNumber") REFERENCES "PaperlessDevice"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessDevice fk_PaperlessDevice_Event; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessDevice"
    ADD CONSTRAINT "fk_PaperlessDevice_Event" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessEventLinkDevice fk_PaperlessEventLinkDevice_Device; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkDevice"
    ADD CONSTRAINT "fk_PaperlessEventLinkDevice_Device" FOREIGN KEY ("DeviceId") REFERENCES "PaperlessDevice"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessEventLinkDevice fk_PaperlessEventLinkDevice_Event; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkDevice"
    ADD CONSTRAINT "fk_PaperlessEventLinkDevice_Event" FOREIGN KEY ("EventId") REFERENCES "PaperlessEvent"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessEventLinkMaterial fk_PaperlessEventLinkMaterial_Event; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkMaterial"
    ADD CONSTRAINT "fk_PaperlessEventLinkMaterial_Event" FOREIGN KEY ("EventId") REFERENCES "PaperlessEvent"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessEventLinkMaterial fk_PaperlessEventLinkMaterial_Material; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkMaterial"
    ADD CONSTRAINT "fk_PaperlessEventLinkMaterial_Material" FOREIGN KEY ("MaterialId") REFERENCES "PaperlessMaterial"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessEventLinkRole fk_PaperlessEventLinkRole_Event; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkRole"
    ADD CONSTRAINT "fk_PaperlessEventLinkRole_Event" FOREIGN KEY ("EventId") REFERENCES "PaperlessEvent"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessEventLinkRole fk_PaperlessEventLinkRole_Role; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEventLinkRole"
    ADD CONSTRAINT "fk_PaperlessEventLinkRole_Role" FOREIGN KEY ("RoleId") REFERENCES "EventRole"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessEvent fk_PaperlessEvent_Event; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessEvent"
    ADD CONSTRAINT "fk_PaperlessEvent_Event" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessMaterialLinkRole fk_PaperlessMaterialLinkRole_Material; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterialLinkRole"
    ADD CONSTRAINT "fk_PaperlessMaterialLinkRole_Material" FOREIGN KEY ("MaterialId") REFERENCES "PaperlessMaterial"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessMaterialLinkRole fk_PaperlessMaterialLinkRole_Role; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterialLinkRole"
    ADD CONSTRAINT "fk_PaperlessMaterialLinkRole_Role" FOREIGN KEY ("RoleId") REFERENCES "EventRole"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessMaterialLinkUser fk_PaperlessMaterialLinkUser_Material; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterialLinkUser"
    ADD CONSTRAINT "fk_PaperlessMaterialLinkUser_Material" FOREIGN KEY ("MaterialId") REFERENCES "PaperlessMaterial"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessMaterialLinkUser fk_PaperlessMaterialLinkUser_User; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterialLinkUser"
    ADD CONSTRAINT "fk_PaperlessMaterialLinkUser_User" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PaperlessMaterial fk_PaperlessMaterial_Event; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "PaperlessMaterial"
    ADD CONSTRAINT "fk_PaperlessMaterial_Event" FOREIGN KEY ("EventId") REFERENCES "Event"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ApiAccountQuotaByUserLog fk__ApiAccountQuotaByUserLog__ApiAccount; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiAccountQuotaByUserLog"
    ADD CONSTRAINT "fk__ApiAccountQuotaByUserLog__ApiAccount" FOREIGN KEY ("AccountId") REFERENCES "ApiAccount"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ApiAccountQuotaByUserLog fk__ApiAccountQuotaByUserLog__User; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "ApiAccountQuotaByUserLog"
    ADD CONSTRAINT "fk__ApiAccountQuotaByUserLog__User" FOREIGN KEY ("UserId") REFERENCES "User"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: -
--

GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m000000_000000_base', 1421938788);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150121_172324_add_column_updatetime_to_payorderitems', 1421938884);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150210_160741_create_new_geo_and_universities_structure', 1424765967);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150310_162421_add_column_starttime_to_competencetest', 1426070470);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150323_210625_add_columns_to_competencetest', 1427145145);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150407_130907_create_pay_food_partner_order_tables', 1428416121);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150506_073131_payproduct_soft_delete', 1430901858);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150508_084203_add_column_public_to_eventparticipant', 1431081022);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150513_080715_add_column_required_to_competencequestion', 1431506668);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150617_094129_paycoupon_soft_delete', 1434540266);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150619_090218_eventsectionlinkuser_soft_delete', 1434721768);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150622_101423_eventsection_soft_delete', 1434979144);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150622_145105_user_merged_fields', 1435045737);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160629_223331_pay_order_import', 1469714456);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160727_102506_pay_log_addon', 1469714460);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160830_061457_user_scope', 1472631167);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160831_190645_pay_account_payonline_ruvents', 1472678557);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160906_070411_section_short_name', 1473174970);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150623_094509_iri', 1435133957);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150629_141225_add_cloudpayments_to_payaccount', 1435592382);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150624_112448_create_user_document_table', 1435763446);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160912_132442_connect', 1473779406);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160922_100134_connect_meeting_types', 1474816365);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150715_102606_add_phonetic_search_to_user', 1437089425);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150730_160807_add_column_for_pay_cabinet_messages', 1438272828);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150731_075558_add_eventrole_visible_column', 1438334184);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150803_144525_ruvents_settings_create_table', 1438683332);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150810_100323_pay_coupon_modify', 1439368710);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150827_074750_add_eventrole_notification_column', 1440664839);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150827_120001_add_payorderitem_refund_columns', 1440758284);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150831_131940_add_payorderjuridicaltemplate_validlimit', 1441027721);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150902_091410_partner_export_table', 1441195225);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150902_144105_add_column_user_verified', 1441620046);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150915_121515_user_referer_table', 1442489538);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150917_143503_payaccount_cabinetjuridicalcreateinfo', 1442501355);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m150928_110553_payaccount_walletone', 1443449408);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m151123_142740_raec_company_users', 1449069930);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m151204_151643_company_code', 1449244829);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m151217_091508_ruvents_visit', 1450348542);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m151224_122656_eventuserdata_trigger', 1450971845);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160929_041725_user_devices', 1475163130);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160113_080640_geo2_to_geo', 1452688941);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160113_134432_geo_trigger_keys', 1452698736);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160118_081432_remove_log', 1453107749);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160524_081432_competence_render_event_header', 1453108000);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160531_111318_add_mail_sending_service', 1464695122);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m160930_131818_connect_cancel', 1475248985);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161002_080904_connect_addons', 1475395924);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161003_094914_connect_reservations_fix', 1475492054);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161002_200918_attribute_translatable', 1475674677);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161011_231720_user_trim', 1476235553);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161013_004322_indexes', 1476325516);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161024_144320_connect_text', 1477322025);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161025_171351_payonline_save', 1477471498);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161129_221848_company_fields', 1480519147);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161202_133436_companies', 1480703761);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161202_141033_order_system', 1481117652);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161214_102646_api_quota', 1481895406);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161219_120509_quota_log_pk', 1482344428);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161221_172948_favorite_widget', 1482344428);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m161212_151136_search_indexes', 1486039886);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170405_161752_paperless_devices', 1491902782);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170407_185600_paperless_material', 1491902783);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170409_160832_paperless_event', 1491902783);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170412_140259_participant_badge', 1492086612);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170413_092439_paperless_material_partner', 1492086612);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170412_102432_ict_tables', 1492165436);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170413_092440_participant_badge', 1492165436);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170414_103058_paperless_devices', 1492192692);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170414_184944_paperless_material', 1492208778);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170414_193508_paperless_device_signal', 1492208780);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170415_062448_event_participant', 1492279685);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170415_195335_paperless_event_materials_link', 1492299995);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170415_215406_paperless_material_user_link', 1492299995);
INSERT INTO public.tbl_migration (version, apply_time) VALUES ('m170414_172903_pay_import', 1493025806);