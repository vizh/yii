CREATE OR REPLACE FUNCTION "public"."UserUpdateTime"()
RETURNS trigger AS
$$
BEGIN
  UPDATE "public"."User" SET "UpdateTime" = LOCALTIMESTAMP(0) WHERE "Id" = NEW."UserId";
RETURN NEW;
END
$$ LANGUAGE plpgsql;