CREATE OR REPLACE FUNCTION "public"."CheckEmploymentPrimary"()
  RETURNS trigger AS
  $$
  BEGIN
    IF NEW."Primary" THEN
      UPDATE "public"."UserEmployment"
      SET "Primary" = FALSE
      WHERE "UserId" = NEW."UserId" AND "Id" != NEW."Id" AND NOT "Primary";
    ELSE
      SELECT * INTO myrec FROM "public"."UserEmployment" WHERE "UserId" = NEW."UserId" AND "Primary";
      IF NOT FOUND THEN
        UPDATE "public"."UserEmployment"
        SET "Primary" = TRUE
        WHERE "UserId" = NEW."UserId" AND "Id" != NEW."Id" AND NOT "Primary";
      END IF;
    END IF;
    RETURN NEW;
  END
  $$ LANGUAGE plpgsql;