import plotly.express as px
import plotly.graph_objects as go
from wordcloud import WordCloud
import matplotlib.pyplot as plt
from io import BytesIO
import base64



class Visualizer:
    def __init__(self):
        # config de base pour les graphiques
        self.colors = ["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd"]

    def make_wordcloud(self, frequencies):
        freq_dict = dict(frequencies)

        wordcloud = WordCloud(width=800, height=400, background_color='white', colormap='viridis', max_words=50).generate_from_frequencies(freq_dict)

        picture, axex = plt.subplots(picsize=(10, 5))
        axex.imshow(wordcloud, interpolation='bilinear')
        axex.axis('off')

        buf = BytesIO()
        plt.savefig(buf, format='png', bbox_inches='tight')
        buf.seek(0)
        plt.close()

        return buf


    def frequencies_graphs (self, frequencies, titre="Mots les plus fréquents"):

        words = [f[0] for f in frequencies[:15]]
        count = [f[1] for f in frequencies[:15]]

        bar = [go.Bar(y=words[::-1], x=count[::-1], orientation='h', marker=dict(color='#2ca02c'))]
        picture = go.Figure(data=bar)

        picture.update_layout(
            title=titre,
            xaxis_title="Fréquence",
            yaxis_title="",
            height=500,
            margin=dict(l=150)
        )
        
        return picture
    
    def entities_graphs (self, entities):
        
        
        types_ent = {}
        for ent in entities:
            type_e = ent['type']
            types_ent[type_e] = types_ent.get(type_e, 0) + 1
        
        if not types_ent:
            return None
        
        # camembert pour les entités (plus visuel)
        picture = go.Figure(data=[
            go.Pie(
                labels=list(types_ent.keys()),
                values=list(types_ent.values()),
                hole=0.3  # donut chart, plus moderne
            )
        ])
        
        picture.update_layout(
            title="Distribution des entités nommées",
            height=400
        )
        
        return picture
    
    def pos_graphs(self, pos_dict):


        pos_sorted = sorted(pos_dict.items(), key=lambda x: x[1], reverse=True)
        
        pos_sorted = pos_sorted[:10]
        
        categories = [p[0] for p in pos_sorted]
        values = [p[1] for p in pos_sorted]
        
        picture = px.bar(
            x=categories,
            y=values,
            labels={'x': 'Type', 'y': 'Nombre'},
            title="Catégories de mots (POS tags)",
            color=values,
            color_continuous_scale='Blues'
        )
        
        picture.update_layout(height=400)
        
        return picture