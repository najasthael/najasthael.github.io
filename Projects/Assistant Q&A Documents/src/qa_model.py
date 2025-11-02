# Auteur: Naja Sthael Gonçalves dos Santos Ferreira
# Mécanisme de questions-réponses utilisant le LLM 

from transformers import pipeline
import torch

class QAModel:
    def __init__(self, model_name = "deepset/roberta-base-squad2"):
        self.qa_pipeline = pipeline("question-answering", model=model_name)

    def answer_question(self, question, context, context_max=500):
        context_max = 3000
        if len(context) > context_max:
            context = context[:context_max]


        result = self.qa_pipeline(question=question, context=context, context_max=context_max)

        return {
            "answer": result["answer"],
            "score": result["score"],
            "start": result["start"],
            "end": result["end"]
        }
    
    def answer_context(self, context, start, end, limit=100):
        context_start = max(0, start - limit)
        context_end = min(len(context), end + limit)
        
        context_extension = context[context_start:context_end]

        if start > 0:
            context_extension = "..." + context_extension
        if end < len(context):
            context_extension = context_extension + "..."
        
        return context_extension

