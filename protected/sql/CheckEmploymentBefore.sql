CREATE OR REPLACE FUNCTION "public"."CheckEmploymentBefore"()
  RETURNS trigger AS
  $$
  DECLARE
    myrec RECORD;
  BEGIN
    IF NEW."Primary" AND NEW."EndYear" IS NOT NULL THEN
      NEW."Primary" = FALSE;

      SELECT * INTO myrec
      FROM "public"."UserEmployment"
      WHERE "UserId" = NEW."UserId" AND "Primary"AND "Id" != NEW."Id";

      IF NOT FOUND THEN
        UPDATE "public"."UserEmployment"
        SET "Primary" = TRUE
        WHERE "UserId" = NEW."UserId" AND "Id" != NEW."Id" AND NOT "Primary" AND "EndYear" IS NULL;
      END IF;
    END IF;
    RETURN NEW;
  END
  $$ LANGUAGE plpgsql;