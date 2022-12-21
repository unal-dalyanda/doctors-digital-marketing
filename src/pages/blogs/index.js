import React, { useEffect, useState } from "react";
import Blog from "../../components/blog/blog";
import { useParams } from "react-router-dom";
import "./style.css";
import Post from "../../components/post/post";

function Blogs() {
  return (
    <>
      {/* <Post /> */}
      <Blog />
    </>
  );
}

export default Blogs;
