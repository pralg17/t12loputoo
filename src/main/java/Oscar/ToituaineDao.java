package Oscar;

import javax.transaction.Transactional;
import org.springframework.data.repository.CrudRepository;
@Transactional
public interface ToituaineDao extends CrudRepository<Toituaine, Long> {
    public Toituaine findByToiduaine(String toiduaine);
}