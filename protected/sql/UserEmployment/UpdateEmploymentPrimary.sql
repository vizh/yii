CREATE OR REPLACE FUNCTION "public"."UpdateEmploymentPrimary"(userid integer)
  RETURNS bool AS
  $$
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
  $$ LANGUAGE plpgsql;