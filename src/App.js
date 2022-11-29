import "./App.css";

import BlogDetail from "./pages/blog-detail/";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Home from "./pages/home";
import MainLayout from "./components/layouts/MainLayout";

function App() {
  return (
    <>
      <Routes>
        <Route element={<MainLayout />}>
          <Route path="/" element={<Home />} exact />

          <Route path="/blogs/:id" element={<BlogDetail />} />
        </Route>
      </Routes>
    </>
  );
}

export default App;
