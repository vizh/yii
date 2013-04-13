CREATE OR REPLACE FUNCTION "public"."UserUpdateTimeByOwnerId"()
RETURNS trigger AS
$$
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
$$ LANGUAGE plpgsql;