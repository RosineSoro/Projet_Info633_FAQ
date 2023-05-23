CREATE TRIGGER ajout_rep
AFTER INSERT ON question
FOR EACH ROW
BEGIN
    INSERT INTO reponse(id_question) VALUES (NEW.id_question);
END;;