CREATE OR REPLACE FUNCTION "public"."UserUpdateTimeByUserId"()
RETURNS trigger AS
$$
BEGIN
  IF (TG_OP = 'DELETE') THEN
    UPDATE "public"."User" SET "UpdateTime" = LOCALTIMESTAMP(0) WHERE "Id" = OLD."UserId";
    RETURN OLD;
  ELSE
    UPDATE "public"."User" SET "UpdateTime" = LOCALTIMESTAMP(0) WHERE "Id" = NEW."UserId";
    RETURN NEW;
  END IF;
END
$$ LANGUAGE plpgsql;