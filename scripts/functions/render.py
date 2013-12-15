import pygame

def render(text, font, background, color, left, top, width, height) : 
		text_rendered = font.render(text, 1, color)
		text_height = font.get_ascent()
		text_rendered = text_rendered.subsurface(pygame.Rect(0, (text_rendered.get_height() - text_height) / 2 , text_rendered.get_width(), text_height))
		rect_rendered = text_rendered.get_rect()
#		final_rect = pygame.Rect(left, top, width, height).fit(rect_rendered)
		final_rect = rect_rendered.fit(pygame.Rect(left, top, width, height))
		background.blit(pygame.transform.smoothscale(text_rendered, (final_rect.width, final_rect.height)), pygame.Rect(left, top, final_rect.width, final_rect.height))
