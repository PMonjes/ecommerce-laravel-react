import { useEffect, useState } from "react";
import { fetchCategories, fetchProducts } from "./services/catalog";

export default function App() {
  const [cats, setCats] = useState([]);
  const [resp, setResp] = useState(null);
  const [err, setErr] = useState("");

  useEffect(() => {
    (async () => {
      try {
        setErr("");
        const [c, p] = await Promise.all([
          fetchCategories(),
          fetchProducts({ page: 1 }),
        ]);
        setCats(c);
        setResp(p);
      } catch (e) {
        setErr("No pude conectar con Laravel. Revisa CORS y que php artisan serve esté corriendo.");
      }
    })();
  }, []);

  return (
    <div style={{ fontFamily: "system-ui", padding: 20 }}>
      <h1>React + Laravel OK</h1>

      {err && <div style={{ padding: 10, background: "#ffecec" }}>{err}</div>}

      <h2>Categorías</h2>
      <ul>
        {cats.map((c) => <li key={c.id}>{c.name} ({c.slug})</li>)}
      </ul>

      <h2>Productos</h2>
      <ul>
        {(resp?.data ?? []).map((p) => (
          <li key={p.id}>
            {p.name} - ${new Intl.NumberFormat("es-CL").format(p.price_cents)} ({p.category?.name ?? "Sin cat"})
          </li>
        ))}
      </ul>
    </div>
  );
}