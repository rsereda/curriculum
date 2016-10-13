INSERT INTO course__module(module_id, course_id) (SELECT
DISTINCT m.id, c.id
FROM module as m
LEFT JOIN competency__module as cm ON cm.module_id = m.id
LEFT JOIN competency__module__course as cmc ON cmc.competency__module_id = cm.id
LEFT JOIN course as c ON c.id = cmc.course_id and c.ready
LEFT JOIN module__study_tree as mst ON mst.module_id = m.id
LEFT JOIN study_tree as st ON mst.study_tree_id = st.id
WHERE c.id is not null);


-- Add column during the transition
ALTER TABLE learning_outcome ADD COLUMN old_id integer;

INSERT into learning_outcome(old_id,denomination,created_at,updated_at,module_id)
(SELECT lo.*, cm.module_id from competency lo
JOIN competency__module cm on cm.competency_id = lo.id
ORDER BY lo.id);

INSERT INTO learning_outcome__learning_outcome(learning_outcome_required_id,learning_outcome_for_id)
SELECT lo.id, lo2.id FROM competency__competency
JOIN learning_outcome lo ON lo.old_id = competency_required_id
JOIN learning_outcome lo2 ON lo2.old_id = competency_for_id;

INSERT INTO cluster__learning_outcome(cluster_id,learning_outcome_id)
(SELECT cluster_id,lo.id from cluster__competency
JOIN learning_outcome lo on lo.old_id = competency_id);

INSERT INTO course_group(denomination,module_id)
(SELECT course_id::text, module_id FROM course__module ORDER BY id);

INSERT INTO course_group__course__module(course__module_id,course_group_id)
(SELECT cm.id,cg.id  FROM course__module cm
JOIN course_group cg ON course_id = cg.denomination::integer and cm.module_id = cg.module_id);


INSERT INTO course_group__learning_outcome(learning_outcome_id, course_group_id)
 (SELECT DISTINCT lo.id,cg.id
FROM module as m
JOIN competency__module as cm ON cm.module_id = m.id
JOIN competency__module__course as cmc ON cmc.competency__module_id = cm.id and (cmc.status = 'accepted' or cmc.status = 'inactive')
JOIN course as c ON c.id = cmc.course_id and c.ready
JOIN learning_outcome lo on lo.module_id = m.id and lo.old_id = cm.competency_id
JOIN course__module c2m on c2m.module_id = m.id and c2m.course_id = c.id
JOIN course_group__course__module cgcm ON cgcm.course__module_id = c2m.id
JOIN course_group cg ON cgcm.course_group_id = cg.id);

-- Drop transition column
ALTER TABLE learning_outcome DROP COLUMN old_id;
