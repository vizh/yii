CREATE OR REPLACE FUNCTION "public"."CreateUserSettings"()
RETURNS trigger AS
$$
BEGIN
INSERT INTO "public"."UserSettings" ("UserId") VALUES (NEW."Id");
RETURN NEW;
END
$$ LANGUAGE plpgsql;