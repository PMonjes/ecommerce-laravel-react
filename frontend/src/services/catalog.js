import { api } from "../lib/api";

export async function fetchCategories() {
  const { data } = await api.get("/api/categories");
  return data;
}

export async function fetchProducts({ category = "", search = "", page = 1 } = {}) {
  const params = {};
  if (category) params.category = category;
  if (search) params.search = search;
  if (page) params.page = page;

  const { data } = await api.get("/api/products", { params });
  return data; // { data:[], meta:{}, links:{} }
}