CREATE OR REPLACE FUNCTION "public"."CheckEmploymentBefore"()
  RETURNS trigger AS
  $$
  BEGIN
    IF NEW."Primary" AND NEW."EndYear" IS NOT NULL THEN
      NEW."Primary" = FALSE;
    END IF;
    RETURN NEW;
  END
  $$ LANGUAGE plpgsql;