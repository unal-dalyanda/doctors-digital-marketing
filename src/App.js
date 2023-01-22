import "./App.css";

import BlogDetail from "./pages/blog-detail/";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Home from "./pages/home";
import Blogs from "./pages/blogs";
import MainLayout from "./components/layouts/MainLayout";
import { HelmetProvider } from 'react-helmet-async';


function App() {
  const helmetContext = {};

  return (
    <>
    <HelmetProvider context={helmetContext} >
    <Routes>
        <Route element={<MainLayout />}>
          <Route path="/" element={<Home />} exact />
          <Route path="/blogs" element={<Blogs />} />

          <Route path="/blogs/:id" element={<BlogDetail />} />
        </Route>
      </Routes>

    </HelmetProvider>
  
    </>
  );
}

export default App;
