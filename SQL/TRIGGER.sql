delimiter ;;
CREATE TRIGGER ajout_rep
AFTER INSERT ON question
FOR EACH ROW
BEGIN
    INSERT INTO reponse(id_question) VALUES (NEW.id_question);
END;;

CREATE TRIGGER enleve rep
BEFORE DELETE ON question
FOR EACH ROW
BEGIN
    DELETE FROM reponse where id_question=OLD.id_question;
END;;
delimiter ;