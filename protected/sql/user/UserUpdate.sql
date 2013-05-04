CREATE OR REPLACE FUNCTION "public"."UserUpdate"()
  RETURNS trigger AS
  $$
  BEGIN
    NEW."UpdateTime" = LOCALTIMESTAMP(0);
    RETURN NEW;
  END
  $$ LANGUAGE plpgsql;