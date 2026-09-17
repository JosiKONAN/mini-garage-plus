import { useEffect, useState } from 'react';
import { useNavigate, useSearchParams, Link } from 'react-router-dom';
import api from '../api';
import LoadingSpinner from '../components/LoadingSpinner';
import ErrorMessage from '../components/ErrorMessage';

export default function ReparationForm() {
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const [vehicules, setVehicules] = useState([]);
  const [techniciens, setTechniciens] = useState([]);
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState(null);

  const today = new Date();
  const todayLocal = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

  const [form, setForm] = useState({
    vehicule_id: searchParams.get('vehicule_id') || '',
    date: todayLocal,
    duree_main_oeuvre: '',
    objet_reparation: '',
    techniciens: [],
  });

  useEffect(() => {
    Promise.all([api.vehicules.list('?per_page=50'), api.techniciens.list()])
      .then(([v, t]) => {
        setVehicules(v.data);
        setTechniciens(t.data);
      })
      .catch(setError)
      .finally(() => setLoading(false));
  }, []);

  function handleChange(e) {
    const { name, value } = e.target;
    setForm((f) => ({ ...f, [name]: value }));
  }

  function toggleTechnicien(id) {
    setForm((f) => ({
      ...f,
      techniciens: f.techniciens.includes(id)
        ? f.techniciens.filter((t) => t !== id)
        : [...f.techniciens, id],
    }));
  }

  async function handleSubmit(e) {
    e.preventDefault();
    setSaving(true);
    setError(null);
    try {
      await api.reparations.create(form);
      navigate('/reparations');
    } catch (err) {
      setError(err);
      setSaving(false);
    }
  }

  if (loading) return <LoadingSpinner />;

  return (
    <div className="row justify-content-center">
      <div className="col-lg-8">
        <Link to="/reparations" className="small">&larr; Retour aux réparations</Link>
        <h1 className="h4 my-3">Nouvelle réparation</h1>

        {error && <ErrorMessage error={error} />}

        <form onSubmit={handleSubmit} className="card">
          <div className="card-body">
            <div className="mb-3">
              <label className="form-label" htmlFor="vehicule_id">Véhicule *</label>
              <select
                id="vehicule_id"
                name="vehicule_id"
                className="form-select"
                value={form.vehicule_id}
                onChange={handleChange}
                required
              >
                <option value="">— Sélectionner un véhicule —</option>
                {vehicules.map((v) => (
                  <option key={v.id} value={v.id}>
                    {v.marque} {v.modele} ({v.immatriculation})
                  </option>
                ))}
              </select>
            </div>

            <div className="row g-3">
              <div className="col-md-5">
                <label className="form-label" htmlFor="date">Date *</label>
                <input
                  type="date"
                  id="date"
                  name="date"
                  className="form-control"
                  value={form.date}
                  onChange={handleChange}
                  required
                />
              </div>
              <div className="col-md-7">
                <label className="form-label" htmlFor="duree_main_oeuvre">Durée de main-d’œuvre (heures) *</label>
                <input
                  type="number"
                  id="duree_main_oeuvre"
                  name="duree_main_oeuvre"
                  className="form-control"
                  min="0"
                  max="999.99"
                  step="0.5"
                  value={form.duree_main_oeuvre}
                  onChange={handleChange}
                  required
                />
              </div>
            </div>

            <div className="mb-3 mt-3">
              <label className="form-label" htmlFor="objet_reparation">Objet de la réparation *</label>
              <input
                type="text"
                id="objet_reparation"
                name="objet_reparation"
                className="form-control"
                maxLength="255"
                value={form.objet_reparation}
                onChange={handleChange}
                required
              />
            </div>

            <div className="mb-3">
              <label className="form-label">Techniciens</label>
              {techniciens.length === 0 ? (
                <p className="form-text mb-0">Aucun technicien enregistré.</p>
              ) : (
                <div className="row g-2">
                  {techniciens.map((t) => (
                    <div className="col-sm-6 col-md-4" key={t.id}>
                      <div className="form-check">
                        <input
                          className="form-check-input"
                          type="checkbox"
                          id={`tech-${t.id}`}
                          checked={form.techniciens.includes(t.id)}
                          onChange={() => toggleTechnicien(t.id)}
                        />
                        <label className="form-check-label small" htmlFor={`tech-${t.id}`}>
                          {t.prenom} {t.nom} — {t.specialite}
                        </label>
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>

            <div className="d-flex gap-2">
              <button type="submit" className="btn btn-primary" disabled={saving}>
                {saving ? 'Enregistrement…' : 'Enregistrer'}
              </button>
              <Link to="/reparations" className="btn btn-outline-secondary">
                Annuler
              </Link>
            </div>
          </div>
        </form>
      </div>
    </div>
  );
}