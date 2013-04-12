CREATE OR REPLACE FUNCTION "public"."CheckEmploymentPrimary"()
RETURNS trigger AS
$$
BEGIN
IF NEW."Primary" THEN
	UPDATE "public"."UserEmployment"
	SET "Primary" = FALSE
	WHERE "UserId" = NEW."UserId" AND "Id" != NEW."Id";
END IF;
RETURN NEW;
END
$$ LANGUAGE plpgsql;