export default function StatCard({ label, value, icon = '📊', color = 'primary' }) {
  return (
    <div className={`card border-0 bg-${color} bg-gradient text-white h-100`}>
      <div className="card-body d-flex align-items-center gap-3">
        <div className="stat-icon rounded-3 bg-white bg-opacity-25 fs-4">{icon}</div>
        <div>
          <div className="fs-3 fw-bold lh-1">{value}</div>
          <div className="small opacity-75">{label}</div>
        </div>
      </div>
    </div>
  );
}