import React from "react";
import "./faq.css";
import { faqData } from "../../data/faqData";

function Faq() {
  return (
    <div className="container" id="faq">
      <h2 className="faq-header">Frequently Asked Questions</h2>
      {faqData.map((item) => (
        <details key={item.id} className="text-container">
          <summary> {item.question} </summary>
          <div> {item.answer} </div>
        </details>
      ))}
    </div>
  );
}

export default Faq;
